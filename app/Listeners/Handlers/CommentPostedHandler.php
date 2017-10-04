<?php namespace App\Listeners\Handlers;


use App\Events\CommentPosted;
use App\Listeners\UserNotificationsGate;
use App\Models\User;

class CommentPostedHandler
{
	/**
	 * Notification rules for CommentPosted event.
	 *
	 * @param CommentPosted $event
	 * @param UserNotificationsGate $gate
	 */
	public function handle(CommentPosted $event, UserNotificationsGate $gate)
	{
		$commentable = $event->comment->commentable;

		$gate->notifyModerators($event);

		$commentableAuthor = $commentable->user;

		if ($commentableAuthor) {
			$gate->notifyPrivate($commentableAuthor, $event);
		}

		$excluded = $this->notifyCoCommentators($commentable, $gate, $event);

		$excluded->push($commentableAuthor);

		if ($commentable->comments->count() === 1){
			// Notify only about the first comment
			$gate->notifyPrivateStream($excluded->pluck('id')->toArray(), $event);
		}
	}

	protected function notifyCoCommentators($commentable, $gate, $event)
	{
		$query = User::select()
			->whereHas('comments', function ($query) use ($commentable) {
				$query->whereIn('id', $commentable->comments->pluck('id'));
			})
			->where('id', '!=', $event->data['actors']['id']);

		if (!empty($commentable->user)) {
			$query->where('id', '!=', $commentable->user->id);
		}

		$users = $query->get();

		foreach ($users as $user) {
			$gate->notifyPrivate($user, $event);
		}

		return $users;
	}
}
