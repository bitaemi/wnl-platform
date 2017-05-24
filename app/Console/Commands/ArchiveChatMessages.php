<?php

namespace App\Console\Commands;

use DB;
use Closure;
use Exception;
use App\Models\ChatRoom;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ArchiveChatMessages extends Command
{
	const ROOM_MESSAGES_KEY = 'room-messages-';

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'chat:archive-messages';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Move old chat messages to MySQL DB';

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 * @return mixed
	 * @throws Exception
	 */
	public function handle()
	{
		$rooms = $this->getRooms();
		if (!$rooms) return;

		foreach ($rooms as $room) {
			$this->moveToMysql($room);
		}

		return;
	}

	/**
	 * Copy rooms and move messages from redis to MySQL.
	 *
	 * @param $room
	 */
	private function moveToMysql($room)
	{
		$room = ChatRoom::firstOrCreate(['name' => $room]);

		$rawMessages = $this->getMessages($room->name);
		$messages = $this->decodeMessages($rawMessages);

		$this->transaction(function () use ($messages, $room, $rawMessages) {
			foreach ($messages as $key => $message) {
				$message = $this->formatMessage($message);
				$room->messages()->create($message);
				$this->removeMessage($room->name, $rawMessages[$key]);
			}
		});
	}

	/**
	 * Search for chat rooms in redis DB.
	 *
	 * @param $cursor
	 * @param int $limit
	 * @return mixed
	 */
	protected function scan($cursor, $limit = 1000)
	{
		return Redis::scan($cursor, 'MATCH', self::ROOM_MESSAGES_KEY . '*', 'COUNT', $limit);
	}

	/**
	 * Get list of chat rooms names.
	 *
	 * @return array
	 */
	protected function getRooms()
	{
		$cursor = null;
		$rooms = [];

		// Redis indicates the beginning,
		// as well as the end of the scan results list
		// by the cursor equal to "0".
		while ($cursor !== 0) {
			list ($cursor, $results) = $this->scan($cursor);
			$cursor = (int)$cursor;
			$rooms = array_merge($rooms, $results);
		}

		$roomsNames = array_map(function ($item) {
			return str_replace(self::ROOM_MESSAGES_KEY, '', $item);
		}, $rooms);

		return $roomsNames;
	}

	/**
	 * Get messages from chat room.
	 *
	 * @param $room
	 * @param int $leave
	 * @param int $take
	 * @return mixed
	 */
	protected function getMessages($room, $leave = 200, $take = 100)
	{
		return Redis::lrange(self::ROOM_MESSAGES_KEY . $room, -1 * ($take + $leave), -1 * ($leave + 1));
	}

	/**
	 * Remove message from chat storage.
	 *
	 * @param $room
	 * @param $message
	 * @return mixed
	 */
	protected function removeMessage($room, $message)
	{
		return Redis::lrem(self::ROOM_MESSAGES_KEY . $room, 0, $message);
	}

	/**
	 * Sanitize single message record
	 * before putting it into MySQL.
	 *
	 * @param $message
	 * @return array
	 */
	protected function formatMessage($message)
	{
		if (empty ($message['user_id'])) {
			$message['user_id'] = null;
		}

		return [
			'content'    => $message['content'],
			'user_id'    => $message['user_id'],
			'created_at' => $message['time'],
		];
	}

	/**
	 * Transform json encoded redis entries into array.
	 *
	 * @param $messages
	 * @return array
	 */
	public function decodeMessages($messages)
	{
		// Much faster than running json_decode()
		// on each message separately.
		$messagesBundle = '[';
		foreach ($messages as $message) {
			$messagesBundle .= $message . ',';
		}
		$messageBundle = substr($messagesBundle, 0, -1);
		$messageBundle .= ']';

		$parsedMessages = json_decode($messageBundle, true);

		return (array)$parsedMessages;
	}

	/**
	 * Execute closure using double transaction (redis + MySQL).
	 *
	 * @param $callback
	 * @throws Exception
	 */
	public function transaction(Closure $callback)
	{
		DB::beginTransaction();
		Redis::multi();

		try {
			$callback();
		}
		catch (Exception $e) {
			DB::rollBack();
			Redis::discard();
			throw $e;
		}

		DB::commit();
		Redis::exec();
	}
}