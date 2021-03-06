<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameColumnInChatRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('chat_rooms', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE chat_rooms MODIFY name VARCHAR(200) NULL');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

		Schema::table('chat_rooms', function(Blueprint $table)
		{
		    if (DB::table('chat_rooms')->count() === 0) {
                // Below statement makes the migration irreversible once there's data in the table.
                // Dropping table in order to restore it's original state does't sound like an alternative.
                DB::statement('ALTER TABLE chat_rooms MODIFY name VARCHAR(200) NOT NULL');
            }
		});
    }
}
