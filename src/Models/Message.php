<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $table = 'messages';

	public function user()
	{
		return $this->belongsTo('App\User');
	}
	
	public function channel()
	{
		return $this->belongsTo('App\Models\Channel');
	}
}