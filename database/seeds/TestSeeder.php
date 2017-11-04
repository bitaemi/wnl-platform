<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(RolesTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(UserProfilesTableSeeder::class);
		$this->call(CoursesTableSeeder::class);
		$this->call(EditionsTableSeeder::class);
		$this->call(GroupsTableSeeder::class);
		$this->call(ReactionsSeeder::class);
		$this->call(TaxonomiesSeeder::class);
		$this->call(ReactionsSeeder::class);
	}
}
