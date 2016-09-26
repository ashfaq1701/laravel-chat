<?php

namespace Ashfaq1701\LaravelChat\Traits;

trait Chattable
{
	public function messages()
	{
		return $this->hasMany('App\Models\Message');
	}
	
	public function channels()
	{
		return $this->belongsToMany('App\Models\Channel');
	}
}