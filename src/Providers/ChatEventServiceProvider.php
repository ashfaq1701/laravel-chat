<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Event;

class ChatEventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Event::listen('Codemash\Socket\Events\ClientConnected', 'App\Listeners\ClientConnectedListener');
        Event::listen('Codemash\Socket\Events\ClientDisconnected', 'App\Listeners\ClientDisconnectedListener');
        Event::listen('Codemash\Socket\Events\MessageReceived', 'App\Listeners\MessageReceivedListener');
    }
}
