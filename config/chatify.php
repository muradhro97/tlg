<?php

return [

    /*
    |-------------------------------------
    | Messenger display name
    |-------------------------------------
    */
    'name' => env('CHATIFY_NAME', 'TLG CHAT ROOM'),

    /*
    |-------------------------------------
    | Routes configurations
    |-------------------------------------
    */
    'routes' => [
        'prefix' => env('CHATIFY_ROUTES_PREFIX', 'chat'),
        'middleware' => env('CHATIFY_ROUTES_MIDDLEWARE', ['web','auth']),
        'namespace' => env('CHATIFY_ROUTES_NAMESPACE', 'Chatify\Http\Controllers'),
    ],

    /*
    |-------------------------------------
    | Pusher API credentials
    |-------------------------------------
    */
    'pusher' => [
        'key' => env('CHAT_PUSHER_APP_KEY'),
        'secret' => env('CHAT_PUSHER_APP_SECRET'),
        'app_id' => env('CHAT_PUSHER_APP_ID'),
        'options' => (array) [
            'cluster' => env('CHAT_PUSHER_APP_CLUSTER'),
            'useTLS' => env('CHAT_PUSHER_APP_USETLS'),
        ],
    ],

    /*
    |-------------------------------------
    | User Avatar
    |-------------------------------------
    */
    'user_avatar' => [
        'folder' => 'users-avatar',
        'default' => 'avatar.png',
    ],

    /*
    |-------------------------------------
    | Attachments
    |-------------------------------------
    */
    'attachments' => [
        'folder' => 'attachments',
        'download_route_name' => 'attachments.download',
        'allowed_images' => (array) ['png','jpg','jpeg','gif'],
        'allowed_files' => (array) ['zip','rar','txt'],
    ],
];
