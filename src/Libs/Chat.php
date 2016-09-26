<?php

namespace Ashfaq1701\LaravelChat\Libs;

class Socket {
	public function javascript()
	{
		$scripts = [
			'<script type="text/javascript" src="'. asset('js/jquery-ajax-fileupload.js') . '"></script>',
			'<script type="text/javascript" src="' . asset('vendor/socket/socket.js') . '"></script>',
			'<script>window.appSocket = new Socket("ws://' . str_replace('/', '', explode(':', url('/'))[1]) . ':' . config('socket.default_port') . '");</script>',
			'<script type="text/javascript" src="' . asset('js/chat.js') . '"></script>'
		];
		return implode('', $scripts);
	}
}