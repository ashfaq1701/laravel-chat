<?php 

namespace Ashfaq1701\LaravelChat\Facades;

use Illuminate\Support\Facades\Facade;

class Chat extends Facade {
    /**
     * Facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'ashfaq1701.chat';
    }
}