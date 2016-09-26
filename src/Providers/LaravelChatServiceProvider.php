<?php

namespace Ashfaq1701\LaravelChat\Providers;

use Illuminate\Support\ServiceProvider;
use Ashfaq1701\LaravelChat\Libs\Chat;

class LaravelChatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {	
    	$this->publishes([
    		__DIR__ . '/../config/chat.php' => config_path('chat.php')
    	]);
    	$this->publishes([
    			__DIR__ . '/../assets/css/chat.css' => public_path('vendor/chat/chat.css'),
    			__DIR__ . '/../assets/css/uielement.css' => public_path('vendor/chat/uielement.css')
    	], 'public-css');
    	$this->publishes([
    			__DIR__ . '/../assets/js/chat.js' => public_path('vendor/chat/chat.js'),
    			__DIR__ . '/../assets/js/jquery-ajax-fileupload.js' => public_path('vendor/chat/jquery-ajax-fileupload.js')
    	], 'public-js');
    	$this->publishes([
    			__DIR__ . '/../Controllers/ChannelController.php' => app_path('Http/Controllers/Chat/ChannelController.php'),
    			__DIR__ . '/../Controllers/ChatController.php' => app_path('Http/Controllers/Chat/ChatController.php'),
    			__DIR__ . '/../Controllers/ChannelController.php' => app_path('Http/Controllers/Chat/ChannelController.php'),
    			__DIR__ . '/../Controllers/FileController.php' => app_path('Http/Controllers/Chat/FileController.php'),
    			__DIR__ . '/../Controllers/MessageController.php' => app_path('Http/Controllers/Chat/MessageController.php'),
    			__DIR__ . '/../Controllers/UploadController.php' => app_path('Http/Controllers/Chat/UploadController.php')
    	], 'controllers');
    	$this->publishes([
    			__DIR__ . '/../Listeners/ClientConnectedListener.php' => app_path('Listeners/ClientConnectedListener.php'),
    			__DIR__ . '/../Listeners/ClientDisconnectedListener.php' => app_path('Listeners/ClientDisconnectedListener.php'),
    			__DIR__ . '/../Listeners/MessageReceivedListener.php' => app_path('Listeners/MessageReceivedListener.php')
    	], 'listeners');
    	$this->publishes([
    			__DIR__ . '/../Models/Channel.php' => app_path('Models/Channel.php'),
    			__DIR__ . '/../Models/Message.php' => app_path('Models/Message.php')
    	], 'models');
    	$this->publishes([
    			__DIR__ . '/../Repositories/ChannelRepository.php' => app_path('Repositories/Chat/ChannelRepository.php'),
    			__DIR__ . '/../Repositories/MessageRepository.php' => app_path('Repositories/Chat/MessageRepository.php'),
    			__DIR__ . '/../Repositories/UploadRepository.php' => app_path('Repositories/Chat/UploadRepository.php')
    	], 'repositories');
    	$this->publishes([
    			__DIR__ . '/../views/chat-top.blade.php' => resource_path('views/chats/chat-top.blade.php'),
    			__DIR__ . '/../views/index.blade.php' => resource_path('views/chats/index.blade.php')
    	], 'views');
    	$this->publishes([
    			__DIR__ . '/ChatEventServiceProvider.php' => app_path('Providers/ChatEventServiceProvider.php')
    	], 'providers');
    	$this->publishes([
    			__DIR__.'/../migrations/' => database_path('migrations')
    	], 'migrations');
    	$this->publishes([
    			__DIR__.'/../seeds/' => database_path('seeds')
    	], 'seeds');
    	
    	$this->appendFileContent(__DIR__ . '/../routes/routes.php', app_path('Http/routes.php'));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	$this->app->bind('ashfaq1701.chat', function () {
    		return new Chat();
    	});
    }
    
    public function appendFileContent($from, $to)
    {
    	$fileContent = file_get_contents ($from);
    	$fileContent = str_replace('<?php', '', $fileContent);
    	file_put_contents($to, $fileContent, FILE_APPEND);
    }
}
