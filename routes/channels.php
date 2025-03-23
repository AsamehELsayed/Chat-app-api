<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{receiver_id}', function ($user, $receiver_id) {

    return (int) $user->id === (int) $receiver_id;
});

Broadcast::channel('user.{sender_id}', function ($user, $sender_id) {

    return (int) $user->id === (int) $sender_id;
});
