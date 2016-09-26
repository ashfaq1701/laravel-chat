<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Channel extends Model
{
	protected $table = 'channels';
	
	public function users()
	{
		return $this->belongsToMany('App\User');
	}
	
	public function messages()
	{
		return $this->hasMany('App\Models\Message');
	}
	
	public function otherUser()
	{
		return $this->users()->whereNotIn('email', [Auth::user()->email])->first();
	}
	
	public function otherThanGivenUser($user)
	{
		return $this->users()->whereNotIn('email', [$user->email])->first();
	}
	
	public function othersThanGivenUser($user)
	{
		return $this->users()->whereNotIn('email', [$user->email])->get();
	}
	
	public function unreadMessages()
	{
		$messages = $this->messages;
		$unreadMessages = array();
		foreach ($messages as $message)
		{
			if(empty($message->read_at))
			{
				$unreadMessages[] = $message;
			}
		}
		return collect($unreadMessages);
	}
	
	public function unreadMessagesCount()
	{
		$count = $this->unreadMessages()->count();
		if($count == 0)
		{
			return null;
		}
		return $count;
	}
}
