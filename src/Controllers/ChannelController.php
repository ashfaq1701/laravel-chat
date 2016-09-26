<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Repositories\Chat\ChannelRepository;

class ChannelController extends Controller
{
	protected $channelRepository;
	
	public function __construct(ChannelRepository $channelRepository)
	{
		$this->channelRepository = $channelRepository;
	}
	
	public function messages($channelId, $pageNumber = 0)
	{
		$result = $this->channelRepository->getChannelMessages($channelId, $pageNumber);
		return response()->json($result);
	}
	
	public function markMessagesRead($channelId)
	{
		$this->channelRepository->markAllRead($channelId);
	}
}