<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MarkLessonsAsRequired extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::table('lessons', function (Blueprint $table) {
			$table->boolean('is_required')->nullable()->after('order_number');
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::table('lessons', function (Blueprint $table) {
			$table->dropColumn(['is_required']);
		});
	}
}
