<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\Channel;

class ChatController extends Controller
{
	public function index()
	{
		return view('chats.index');
	}
	
	public function chatTop($channelId)
	{
		$channel = Channel::find($channelId);
		return view('chats.chat-top', compact('channel'));
	}
}