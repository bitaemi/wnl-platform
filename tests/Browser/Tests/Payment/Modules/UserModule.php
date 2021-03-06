<?php


namespace Tests\Browser\Tests\Payment\Modules;


use App\Models\User;
use Faker\Generator;
use Faker\Provider\Internet;
use Faker\Provider\pl_PL\Address;
use Faker\Provider\pl_PL\Person;
use Faker\Provider\pl_PL\PhoneNumber;
use Tests\Browser\Pages\Login;

class UserModule
{
	public function newUser($browser)
	{
		return [
			SelectProductModule::class,
			VoucherModule::class,
			PersonalDataModule::class,
		];
	}

	public function existingUser($browser)
	{
		$faker = new Generator();
		$faker->addProvider(new Person($faker));
		$faker->addProvider(new Address($faker));
		$faker->addProvider(new Internet($faker));
		$faker->addProvider(new PhoneNumber($faker));
		$user = User::create([
			'first_name' => $faker->firstName,
			'last_name'  => $faker->lastName,
			'email'      => $faker->unique()->safeEmail,
			'password'   => bcrypt('secret'),
		]);
		$user->userAddress()->firstOrCreate([
			'phone'      => $faker->phoneNumber,
			'street'     => $faker->address,
			'zip'        => $faker->postcode,
			'city'       => $faker->city,
		]);
		$browser->user = $user;

		$browser
			->visit(new Login())
			->loginAsUser($user->email, 'secret');

		return [
			SelectProductModule::class,
			VoucherModule::class,
			PersonalDataModule::class,
		];
	}
}
