<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snake game dependents
    |--------------------------------------------------------------------------
    |
    | These values are necessary to handle data between web app and game desktop app.
    |
    */
    'version' => env('GAME_VERSION'),
    'secret_key' => env('SECRET_GAME_KEY')

];
