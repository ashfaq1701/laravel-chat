<?php

namespace App\Repositories\Chat;

use App\Models\Channel;
use App\Models\Message;
use App\User;

class MessageRepository
{	
	public function saveTextMessage($message, $user)
	{
		$messageObject = json_decode($message);
		$channelID = $messageObject->channel_id;
		$channel = Channel::find($channelID);
		$message = new Message();
		$message->type = 'text';
		$message->text = $messageObject->text;
		$message->channel_id = $channel->id;
		$message->user_id = $user->id;
		$message->save();
		
		$user = User::find($message->user_id);
		$message->user = $user;
		
		return [
				'message' => $message,
				'channel' => $channel
		];
	}
	
	public function saveFileMessage($message, $user)
	{
		$messageObject = json_decode($message);
		$filename = $messageObject->file;
		$channelID = $messageObject->channel_id;
		$channel = Channel::find($channelID);
		
		$file = public_path(). "/uploads/files/".$filename;
		
		if($this->isImage($file) == true)
		{
			$message = new Message();
			$message->type = 'image';
			$message->file_path = config('chat.base_url').'/images/'.$filename;
			$message->channel_id = $channel->id;
			$message->user_id = $user->id;
			$message->save();
		}
		else
		{
			$message = new Message();
			$message->type = 'file';
			$message->file_path = config('chat.base_url').'/files/'.$filename;
			$message->channel_id = $channel->id;
			$message->user_id = $user->id;
			$message->save();
		}
		
		$user = User::find($message->user_id);
		$message->user = $user;
		
		return [
				'message' => $message,
				'channel' => $channel
		];
	}
	
	function isImage($path)
	{
		$a = getimagesize($path);
		$image_type = $a[2];
	
		if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
		{
			return true;
		}
		return false;
	}
}