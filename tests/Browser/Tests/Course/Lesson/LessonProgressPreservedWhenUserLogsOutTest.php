<?php

namespace Tests\Browser;

use Tests\Browser\Pages\Course\Course;
use Tests\Browser\Pages\Course\Lesson;
use Tests\Browser\Pages\Course\Components\Navigation;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LessonProgressPreservedWhenUserLogsOutTest extends DuskTestCase
{

	/**
	 * @dataProvider Tests\Browser\DataProviders\User::userProvider
	 * @param String $email
	 * @param String $password
	 * @param String $name
	 */
	public function testLessonProgressPreservedWhenUserLogsOut($email, $password, $name)
	{
		$this->browse(function (Browser $browser) use ($email, $password, $name) {
			$browser->maximize()
				->visit(new Login())
				//TODO this is needed until we implement progress state in localStorage better
				->clearUserData()
				->loginAsUser($email, $password)
				->visit(new Lesson())
				->waitFor('@side_nav', 15)
				->goToSection(2)
				->assertExpectedSectionActive(2)
				->on(new Navigation())
				->logoutUser()
				->on(new Login())
				->waitFor('@email_input')
				->loginAsUser($email, $password)
				->on(new Course())
				->waitFor('@side_nav', 15)
				->goToLesson(1)
				->on(new Lesson())
				->waitFor('@side_nav', 15)
				->assertExpectedSectionActive(2);
		});
	}
}