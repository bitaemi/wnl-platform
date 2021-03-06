<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserDetailsToUserProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('city')->nullable()->after('avatar');
            $table->string('university')->nullable()->after('city');
            $table->text('specialization')->nullable()->after('university');
            $table->text('help')->nullable()->after('specialization');
            $table->text('interests')->nullable()->after('help');
            $table->text('about')->nullable()->after('interests');
            $table->string('learning_location')->nullable()->after('about');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('university');
            $table->dropColumn('specialization');
            $table->dropColumn('help');
            $table->dropColumn('interests');
            $table->dropColumn('about');
            $table->dropColumn('learning_location');
        });
    }
}
