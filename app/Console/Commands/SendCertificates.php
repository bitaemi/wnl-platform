<?php

namespace App\Console\Commands;

use App\Jobs\SendCertificate;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Storage;

class SendCertificates extends Command
{
	use DispatchesJobs;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'certificates:send';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send certificates';

	const BASE_DIRECTORY = 'certyfikaty';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$files = Storage::disk('s3')->files(self::BASE_DIRECTORY);

		foreach ($files as $file) {
			$id = str_replace([self::BASE_DIRECTORY . '/', '.pdf'], '', $file);
			$user = User::find($id);
			if (!$user) {
				$this->warning('User not found ' . $id);
				continue;
			}
			$this->dispatch(new SendCertificate($user, $file));
			print '.';
		}
	}
}
