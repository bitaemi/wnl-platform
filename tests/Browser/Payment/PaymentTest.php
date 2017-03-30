<?php

namespace Tests\Browser\Payment;

use Facebook\WebDriver\WebDriverPoint;
use Faker\Factory;
use Tests\Browser\Pages\Payment\ConfirmOrderPage;
use Tests\Browser\Pages\Payment\P24AcceptTou;
use Tests\Browser\Pages\Payment\P24ChooseBank;
use Tests\Browser\Pages\Payment\PersonalDataPage;
use Tests\Browser\Pages\Payment\SelectProductPage;
use Tests\Browser\Pages\User\OrdersPage;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PaymentTest extends DuskTestCase
{
	use SignsUpUsers;

	/**
	 * @var (Faker) Factory
	 */
	protected $faker;

	/**
	 * Setup faker
	 */
	public function setUp()
	{
		parent::setUp();
		$this->faker = Factory::create();
	}

	/** @test */
	public function user_can_sign_up_and_place_order()
	{
		$this->browse(function ($browser) {
			$browser
				->visit(new SelectProductPage)
				->clickLink('Wybieram kurs stacjonarny');

			$user = $this->generateFormData($this->faker);
			$browser->on(new PersonalDataPage);
			$this->fillInForm($user, $browser);
			$browser->xpath('.//button[@class="button is-primary"]')->click();

			$browser
				->on(new ConfirmOrderPage)
				->assertSeeAll([$user['email'], $user['firstName'], $user['lastName'], $user['address']])
				->xpath('.//button[1]')->click();

			$browser
				->on(new OrdersPage)
				->waitForAll(['Twoje zamówienia', $user['firstName'], $user['lastName']]);

		});

		$this->closeAll();
	}

	/** @test */
	public function user_can_place_order_and_successfully_pay_online()
	{
		if (env('APP_ENV') === 'production') {
			print PHP_EOL . 'Omitting test ' . __METHOD__ . ' (not applicable on production)';

			return true;
		}

		$this->browse(function ($browser) {
			$browser
				->visit(new SelectProductPage)
				->clickLink('Wybieram kurs internetowy');

			$user = $this->generateFormData($this->faker);
			$browser->on(new PersonalDataPage);
			$this->fillInForm($user, $browser);
			$browser->xpath('.//button[@class="button is-primary"]')->click();

			$browser
				->on(new ConfirmOrderPage)
				->assertSeeAll([$user['email'], $user['firstName'], $user['lastName'], $user['address']])
				->press('@online-payment-button');

			$browser
				->on(new P24ChooseBank)
				->press('@ing-logo')
				->press('@accept-tou')
				->press('@confirm-payment');

			$browser
				->waitForAll(['Twoje zamówienia', $user['firstName'], $user['lastName']])
				->waitForText('Zapłacono!', 60);
		});

		$this->closeAll();
	}

	/** @test */
	public function user_cant_place_order_and_request_an_invoice()
	{
		$this->browse(function ($browser) {
			$browser
				->visit(new SelectProductPage)
				->clickLink('Wybieram kurs internetowy');

			$user = $this->generateFormData($this->faker);
			$browser->on(new PersonalDataPage);
			$this->fillInForm($user, $browser, $invoice = true);
			$browser->xpath('.//button[@class="button is-primary"]')->click();

			$browser
				->on(new ConfirmOrderPage)
				->assertSeeAll([
					$user['email'],
					$user['firstName'],
					$user['lastName'],
					$user['address'],
					$user['invoice_company'],
					$user['invoice_address'],
					$user['invoice_postcode'],
					$user['invoice_country'],
				])
				->xpath('.//button[1]')->click();

			$browser
				->on(new OrdersPage)
				->waitForAll(['Twoje zamówienia', $user['firstName'], $user['lastName']]);
		});

		$this->closeAll();
	}
}
