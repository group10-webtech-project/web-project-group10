<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('delivery', function () {
    return true;
});

Broadcast::channel('rooms.{id}', function ($user, $id) {
    return (int) $user->room_id === (int) $id;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
