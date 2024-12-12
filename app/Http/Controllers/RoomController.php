<?php

namespace App\Http\Controllers;

use App\Jobs\TimerEnded;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Room;
use App\Events\UserJoined;
use App\Events\GameStart;
use App\Events\PackageSent;
use Illuminate\Support\Facades\Auth;


class RoomController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            TimerEnded::dispatch()->delay(now()->addMinutes(1));
            $user = Auth::user();
            $roomCode = Str::random(6);

            $room = Room::create([
                'room_code' => $roomCode,
                'active' => true,
                'admin_id' => $user->id
            ]);


            return redirect()->route('rooms.join', $room->id);
        }
        else {
            return "You have to login to play create a room";
        }
    }

    public function join($id)
    {
        PackageSent::dispatch(['data'=>'ads']);

        if (Auth::check()) {
            $room = Room::findOrFail($id);
            $user = Auth::user();

            $user->room_id = $room->id;
            $user->save();

            UserJoined::dispatch($user);
            return view('room', [
                'room' => $room,
                'player' => $user,
            ]);
        }
        else {
            return "You have to login to play multiplayer";
        }
    }

    public function start($id)
    {
        $room = Room::findOrFail($id);
        if (Auth::check()) {
            $user = Auth::user();
            if($user->id == $room->admin_id) {
                GameStart::dispatch($room);

                return response()->json([
                    'message' => 'Game has started.',
                    'status' => 'success',
                ]);
            }
            else {
                return response()->json([
                    'message' => "You don't have permission to start the game",
                    'status' => 'error',
                ]);
            }
        }
        else {
            return response()->json([
                'message' => 'You have to login to play multiplayer.',
                'status' => 'error',
            ]);
        }
    }
}
