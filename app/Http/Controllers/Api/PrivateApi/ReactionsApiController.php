<?php namespace App\Http\Controllers\Api\PrivateApi;

use App\Events\Reactions\ReactionAdded;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Reactions\DeleteReaction;
use App\Models\Reaction;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ReactionsApiController extends ApiController
{
	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->resourceName = config('papi.resources.reactions');
	}

	public function postMany(Request $request)
	{
		$user = Auth::user();
		$reactions = $request->all();

		foreach ($reactions as $index => $reactionParam) {
			$modelName = self::getResourceModel($reactionParam['reactable_resource']);
			$reactable = $modelName::find($reactionParam['reactable_id']);
			$reaction = Reaction::type($reactionParam['reaction_type']);
			$context = $request->get('context');

			if (!$reactable || !$reaction) {
				return $this->respondNotFound();
			}

			$now = Carbon::now();

			try {
				$reactable->reactions()->attach($reaction, [
					'user_id'    => $user->id,
					'created_at' => $now,
					'updated_at' => $now,
					'context'    => $context,
				]);

				// Since there's no action performed on reaction model,
				// we have to trigger the event manually.
				event(new ReactionAdded($reaction, $reactable, $user->id));
			} catch (\Illuminate\Database\QueryException $e) {
				if ($e->errorInfo[1] === 1062) {
					// Means user already has this reaction, ignore exception because I can't think of anything better
				} else {
					return $this->respondInternalError($e->getMessage());
				}
			}
		}

		return $this->respondCreated();
	}

	public function destroy(DeleteReaction $request)
	{
		$user = Auth::user();

		$modelName = self::getResourceModel($request->get('reactable_resource'));
		$reactable = $modelName::find($request->get('reactable_id'));
		$reaction = Reaction::type($request->get('reaction_type'));

		if (!$reactable || !$reaction) {
			return $this->respondNotFound();
		}

		DB::table('reactables')
			->where('user_id', $user->id)
			->where('reactable_id', $reactable->id)
			->where('reactable_type', 'App\Models\\' . class_basename($reactable))
			->where('reaction_id', $reaction->id)
			->delete();

		return $this->respondOk();
	}
}
