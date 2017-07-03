<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Models\User;

Route::group(['namespace' => 'Api\PrivateApi', 'middleware' => 'api-auth'], function () {
	$r = config('papi.resources');

	// Courses
	Route::get("{$r['courses']}/{id}", 'Course\CoursesApiController@get');

	// Groups
	Route::get("{$r['groups']}/{id}", 'Course\GroupsApiController@get');

	// Lessons
	Route::get("{$r['lessons']}/{id}", 'Course\LessonsApiController@get');
	Route::put("{$r['lessons']}/{id}", 'Course\LessonsApiController@put');

	// Screens
	Route::post("{$r['screens']}", 'Course\ScreensApiController@post');
	Route::get("{$r['screens']}/{id}", 'Course\ScreensApiController@get');
	Route::put("{$r['screens']}/{id}", 'Course\ScreensApiController@put');
	Route::patch("{$r['screens']}/{id}", 'Course\ScreensApiController@patch');
	Route::delete("{$r['screens']}/{id}", 'Course\ScreensApiController@delete');
	Route::post("{$r['screens']}/.search", 'Course\ScreensApiController@search');

	// Editions
	Route::get("{$r['editions']}/{id}", 'Course\EditionsApiController@get');

	// Slides
	Route::get("{$r['slides']}/{id}", 'Course\SlidesApiController@get');
	Route::put("{$r['slides']}/{id}", 'Course\SlidesApiController@put');
	Route::post("{$r['slides']}/.search", 'Course\SlidesApiController@search');

	// Presentables
	Route::post("{$r['presentables']}/.search", 'Course\PresentablesApiController@search');
	Route::get("{$r['presentables']}/{id}", 'Course\PresentablesApiController@get');

	// Slideshows
	Route::get("{$r['slideshows']}/{id}", 'Course\SlideshowsApiController@get');

	// Users
	Route::get("{$r['users']}/{id}", 'User\UsersApiController@get');
	Route::put("{$r['users']}/{id}", 'User\UsersApiController@put');

	Route::get("{$r['users']}/{id}/{$r['user-profile']}", 'User\UserProfileApiController@get');
	Route::put("{$r['users']}/{id}/{$r['user-profile']}", 'User\UserProfileApiController@put');

	Route::post("{$r['users']}/{id}/{$r['user-avatar']}", 'User\UserAvatarApiController@post');

	Route::get("{$r['users']}/{id}/{$r['user-address']}", 'User\UserAddressApiController@get');
	Route::put("{$r['users']}/{id}/{$r['user-address']}", 'User\UserAddressApiController@put');

	Route::get("{$r['users']}/{id}/{$r['user-billing-data']}", 'User\UserBillingApiController@get');
	Route::put("{$r['users']}/{id}/{$r['user-billing-data']}", 'User\UserBillingApiController@put');

	Route::get("{$r['users']}/{id}/{$r['user-settings']}", 'User\UserSettingsApiController@get');
	Route::put("{$r['users']}/{id}/{$r['user-settings']}", 'User\UserSettingsApiController@put');

	Route::put("{$r['users']}/{id}/{$r['user-password']}", 'User\UserPasswordApiController@put');

	Route::get("{$r['users']}/{id}/{$r['user-notifications']}", 'User\UserNotificationApiController@get');
	Route::post("{$r['users']}/{id}/{$r['user-notifications']}/.search", 'User\UserNotificationApiController@search');
	Route::patch("{$r['users']}/{id}/{$r['user-notifications']}/{notificationId}", 'User\UserNotificationApiController@patch');

	Route::get("{$r['users']}/{id}/{$r['user-state']}/course/{courseId}", 'User\UserStateApiController@getCourse');
	Route::put("{$r['users']}/{id}/{$r['user-state']}/course/{courseId}", 'User\UserStateApiController@putCourse');

	Route::get("{$r['users']}/{id}/{$r['user-state']}/course/{courseId}/lesson/{lessonId}", 'User\UserStateApiController@getLesson');
	Route::put("{$r['users']}/{id}/{$r['user-state']}/course/{courseId}/lesson/{lessonId}", 'User\UserStateApiController@putLesson');

	Route::get("{$r['users']}/{id}/{$r['user-state']}/quiz/{quizId}", 'User\UserStateApiController@getQuiz');
	Route::put("{$r['users']}/{id}/{$r['user-state']}/quiz/{quizId}", 'User\UserStateApiController@putQuiz');

	Route::get("{$r['users']}/{user}/{$r['user-state']}/time", 'User\UserStateApiController@getTime');
	Route::put("{$r['users']}/{id}/{$r['user-state']}/time", 'User\UserStateApiController@incrementTime');

	Route::get("{$r['users']}/{user}/{$r['user-reactions']}/{type?}", 'User\UserReactionsApiController@getReactions');

	// Orders
	Route::get("{$r['orders']}/{id}", 'OrdersApiController@get');

	// Tags
	Route::get("{$r['tags']}/{id}", 'TagsApiController@get');
	Route::post("{$r['tags']}/.search", 'TagsApiController@search');
	Route::get("{$r['tags']}", 'TagsApiController@getAll');

	// Q&A Questions
	Route::post($r['questions'], 'Qna\QuestionsApiController@post');
	Route::get("{$r['questions']}/{id}", 'Qna\QuestionsApiController@get');
	Route::put("{$r['questions']}/{id}", 'Qna\QuestionsApiController@put');
	Route::delete("{$r['questions']}/{id}", 'Qna\QuestionsApiController@delete');
	Route::post("{$r['questions']}/.search", 'Qna\QuestionsApiController@search');

	// Q&A Answers
	Route::post($r['answers'], 'Qna\AnswersApiController@post');
	Route::get("{$r['answers']}/{id}", 'Qna\AnswersApiController@get');
	Route::put("{$r['answers']}/{id}", 'Qna\AnswersApiController@put');
	Route::delete("{$r['answers']}/{id}", 'Qna\AnswersApiController@delete');
	Route::post("{$r['answers']}/.search", 'Qna\AnswersApiController@search');

	// Quiz Sets
	Route::get("{$r['quiz-sets']}/{id}", 'Quiz\QuizSetsApiController@get');
	Route::post("{$r['quiz-sets']}", 'Quiz\QuizSetsApiController@post');

	// Quiz Stats
	Route::get("{$r['quiz-sets']}/{id}/stats", 'Quiz\QuizStatsApiController@get');

	// Quiz Questions
	Route::post("{$r['quiz-questions']}/.search", 'Quiz\QuizQuestionsApiController@search');

	// Comments
	Route::post($r['comments'], 'CommentsApiController@post');
	Route::get("{$r['comments']}/{id}", 'CommentsApiController@get');
	Route::put("{$r['comments']}/{id}", 'CommentsApiController@put');
	Route::delete("{$r['comments']}/{id}", 'CommentsApiController@delete');
	Route::post("{$r['comments']}/.search", 'CommentsApiController@search');

	// Chat Messages
	Route::post(
		"{$r['chat-rooms']}/{roomName}/{$r['chat-messages']}/.search",
		'Chat\ChatMessagesApiController@searchByRoom'
	);

	// Reactions
	Route::post($r['reactions'], 'ReactionsApiController@post');
	Route::delete("{$r['reactions']}", 'ReactionsApiController@destroy');

	// Public image upload
	Route::post("upload", 'UploadApiController@post');

	// User Progress
//	Route::get("{$r['users']}/{id}", 'CoursesApiController@get');
//	Route::put("{$r['users']}/{id}", 'CoursesApiController@put');

});
