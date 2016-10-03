<?php

namespace App\Listeners;

use Codemash\Socket\Events\MessageReceived;
use App\Repositories\Chat\MessageRepository;
use App\Repositories\Chat\ChannelRepository;

class MessageReceivedListener
{
	protected $messageRepository;
	protected $channelRepository;
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct(MessageRepository $messageRepository, ChannelRepository $channelRepository)
	{
		$this->messageRepository = $messageRepository;
		$this->channelRepository = $channelRepository;
	}

	/**
	 * Handle the event.
	 *
	 * @param  MessageReceived  $event
	 * @return void
	 */
	public function handle(MessageReceived $event)
	{
		$user = $event->client->getUser();
		$message = $event->message;
		$command = $message->command;
		$data = $message->data;
		$message = $data->scalar;
		if($command === 'textMessage')
		{
			$returnValue = $this->messageRepository->saveTextMessage($message, $user);
			$message = $returnValue['message'];
			$channel = $returnValue['channel'];
			$users = $channel->users;
			foreach ($users as $currentUser)
			{
				if(!(($currentUser->is_online == 0) || empty($currentUser->is_online)))
				{
					$client = $event->clients->get($currentUser->connection_id);
					$client->send('textMessage', json_encode($message));
				}
			}
		}
		else if($command == 'fileMessage')
		{
			$returnValue = $this->messageRepository->saveFileMessage($message, $user);
			$message = $returnValue['message'];
			$channel = $returnValue['channel'];
			$users = $channel->users;
			foreach ($users as $currentUser)
			{
				if(!(($currentUser->is_online == 0) || empty($currentUser->is_online)))
				{
					$client = $event->clients->get($currentUser->connection_id);
					$client->send('fileMessage', json_encode($message));
				}
			}
		}
	}
}