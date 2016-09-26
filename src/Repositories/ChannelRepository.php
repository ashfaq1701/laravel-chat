<?php

namespace App\Repositories\Chat;

use Auth;
use App\Models\Channel;
use Carbon\Carbon;

class ChannelRepository
{
	public function getChannelMessages($channelId, $pageNumber)
	{
		$channel = Channel::find($channelId);
		$messages = $channel->messages()->with('user')->get();
		$messages = $messages->sortByDesc('created_at');
		$pagedMessages = $messages->slice($pageNumber*50, 50);
		$pagedMessages = $pagedMessages->reverse()->all();
		$result = [
			'messages' => $pagedMessages,
			'more' => $this->haveMoreMessages($channelId, $pageNumber)
		];
		return $result;
	}
	
	public function haveMoreMessages($channelId, $pageNumber)
	{
		$channel = Channel::find($channelId);
		$messagesCount = $channel->messages()->count();
		$more = $messagesCount > (($pageNumber + 1) * 50) ? true : false;
		return $more;
	}
	
	public function markAllRead($channelId)
	{
		$channel = Channel::find($channelId);
		$messages = $channel->messages()->whereNull('read_at')->get();
		foreach($messages as $message)
		{
			$message->read_at = Carbon::now();
			$message->save();
		}
	}
}