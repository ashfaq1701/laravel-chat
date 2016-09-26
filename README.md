# Laravel Chat

This package is a simple but feature rich implementation of chatting functionality using [Ratchet](https://github.com/ratchetphp/Ratchet) based Laravel pacakage [Laravel Socket](https://github.com/codemash/laravel-socket). It is a channel based chatting platform which has base for group chatting, file and image messaging with image display on client side. Also it has push notification for user online and offline status. Has limited message loading and load more option. At once even with required modification of css, it can be deployed as a chat application at once. It has easy installation procedure and published resources to adapt to any use cases.


## Requirements

Laravel 5.2. 5.3 support coming soon.

## Installation


You can install the package using the [Composer](https://getcomposer.org/) package manager. You can install it by running this command in your project root:

```sh
composer require ashfaq1701/laravel-chat
```

Add the `Codemash\Socket\SocketServiceProvider` and `Ashfaq1701\LaravelChat\Providers\LaravelChatServiceProvider` provider to the `providers` array in `config/app.php`':

```php
'providers' => [
    ...
    Codemash\Socket\SocketServiceProvider::class,
    Ashfaq1701\LaravelChat\Providers\LaravelChatServiceProvider::class,
],
```
Then run the following command,

```sh
php artisan vendor:publish
```

The published assets can be found at `config/socket.php`, `config/chat.php`, `app/Http/Controllers/Chat`, `app/Repositories`, `app/Listeners`, `app/Models`, `database/migrations`, `database/seeds`, `resources/views/chat`, css and javascripts at `public/vendor/socket` and `public/vendor/chat` directories. Routes will be published too. It is important to know that the `Chat::javascript()` facade function will include both a default socket located at `window.appSocket` and `socket.js`, `ajax-fileupload.js` and `chat.js` source file located in the vendor folder. These are merely a start, and provide a quick way to work with the chats and sockets but you are always free to write a custom implementation.

After publish you have to follow some steps again.

Add `App\Providers\ChatEventServiceProvider` to the `providers` array in `config/app.php`.

```php
'providers' => [
    ...
    App\Providers\ChatEventServiceProvider::class,
],
```

Then, add the facades to your `aliases` array. The default facade provides an easy-to-use interface to integrate the socket files in your view.

```php
'aliases' => [
    ...
    'Socket' => Codemash\Socket\Facades\Socket::class,
    'Chat' => Ashfaq1701\LaravelChat\Facades\Chat::class,
]
```

Then run migrations,

```sh
php artisan migrate
```

There are few helping seeds provided for you to get you started. To run them add then in the run method of `DatabaseSeeder` class. You could need composer dump-autoload command once for the publish to be effected for seeders.

```php
public function run()
{
    $this->call(UserTableSeeder::class);
    $this->call(ChannelsUsersTableSeeder::class);
}
```

Then run those seeders,

```sh
php artisan db:seed
```

Use the `Ashfaq1701\LaravelChat\Traits\Chattable` trait from the `App\User` model.

```php
...
use Ashfaq1701\LaravelChat\Traits\Chattable;

class User extends Authenticatable
{
	use Chattable;
	...
```

Then inside `App\Http\Middleware\VerifyCsrfToken.php` exclude the ajax file upload route from the CSRF protection. This is required otherwise the file and image messages will not work. Also inside `public\`, create `uploads\files` empty directory.

```php
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
    	'/uploads/file'
    ];
}
```

The last thing is add a section in the `resources\views\layouts\app.blade.php`. At the end of all javascript declarations, add a section named `custom-scripts`. Like this,

```php
	...
	@yield('content')
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @yield('custom-scripts')
</body>
</html>

```

## Getting started

Finally, let's run the socket listener. You can do this by running the following artisan command in the project root:

```sh
php artisan socket:listen
```

After that run the application (for dev).

```sh
php artisan serve
```

Check database for a set of email and password (preferably first user if the seeder ran). Then login to the system and visit `http://localhost:8000/chat` url. You will see a fully functional chat running. Experiment with it. All files are published, so you can do almost any customization you need.

## Production

Ubuntu provides the neat `nohup` tool, which runs processes on the background. In case you'd like to run your socket on a production server and you're on Ubuntu, you may always use the nohup tool to run the socket listener.

```sh
nohup php artisan socket:listen &
```

When using the `jobs` command, you'll see the socket running. It's easy to kill the process using the `kill <pid>` command. The process ID is listed in the jobs list.

## Contributing

If you're having problems, spot a bug, or have a feature suggestion, please log and issue on Github. If you'd like to have a crack yourself, fork the package and make a pull request. Any improvements are more than welcome.
