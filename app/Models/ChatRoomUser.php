<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoomUser extends Model
{
	protected $table = 'chat_room_user';

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function room()
	{
		return $this->belongsTo('App\Models\ChatRoom');
	}
}
