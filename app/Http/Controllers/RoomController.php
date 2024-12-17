<?php

namespace App\Http\Controllers;

use App\Jobs\Timer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Room;
use App\Models\Animal;
use App\Events\UserJoined;
use App\Events\GameStart;
use App\Events\GameEnded;
use Illuminate\Support\Facades\Auth;


class RoomController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $roomCode = Str::random(6);

            $room = Room::create([
                'room_code' => $roomCode,
                'active' => false,
                'admin_id' => $user->id
            ]);


            return redirect()->route('rooms.join', $room->id);
        }
        else {
            return "You have to login to create a room";
        }
    }

    public function join($id)
    {
        if (Auth::check()) {
            $room = Room::findOrFail($id);
            if (!$room->active)
            {
                $user = Auth::user();

                $user->room_id = $room->id;
                $user->current_room_score = 0;
                $user->finished_in_room = true;
                $user->save();

                UserJoined::dispatch($user);
                return redirect()->route('rooms.index', $id);
            }
            else {
                return "The game has already started in this room, try later.";
            }
        }
        else {
            return "You have to login to play multiplayer";
        }
    }

    public function finish($id) {
        if (Auth::check()) {
            $room = Room::findOrFail($id);
            $user = Auth::user();
            if ($user->fnished_in_room)
            {
                return "Already finished playing!";
            }

            if ($room->id == $user->room_id)
            {
                $user->finished_in_room = true;
                $user->save();
                UserJoined::dispatch($user);

                if($room-> active && !$room->users()->where('finished_in_room', false)->exists())
                {
                    $room->active = false;
                    $room->save();
                    GameEnded::dispatch($room);
                }

                return redirect()->route('rooms.index', $id);
            }
            else {
                return "Room error.";
            }
        }
        else {
            return "You have to login to play multiplayer";
        }
    }

    public function joinWithCode(Request $request) {
        $roomCode = $request->validate([
            'room_code' => 'string|required',
        ]);
        $room = Room::where('room_code', $roomCode['room_code'])->firstOrFail();
        return redirect()->route('rooms.join', $room->id);
    }

    public function index($id) {
        if (Auth::check()) {
            $user = Auth::user();
            $room = Room::findOrFail($id);
            if($user->room_id == $room->id) {
                return view('room', [
                    'room' => $room,
                    'animalCount' => Animal::count(),
                    'users' => $room->users->where('finished_in_room', true)->sortByDesc('current_room_score'),
                    'user' => $user,
                ]);
            }
            else {
                return "You are not part of this room.";
            }
        }
        else {
            return "You have to login to play multiplayer";
        }
    }

    public function start(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $config = $request->validate([
            'number_of_animals' => 'required|integer|min:1|max:'.Animal::count(),
            'minutes' => 'required|integer|min:1|max:60',
            'seconds' => 'required|integer|min:0|max:59',
        ]);

        if (Auth::check()) {
            $user = Auth::user();
            if($user->id == $room->admin_id) {
                if(!$room->active)
                {
                    $room = Room::findOrFail($id);
                    $room->assignRandomAnimals((int)$config['number_of_animals']);
                    $room->active = true;
                    $room->game_end_at = now()->addMinutes((int)$config['minutes'])->addSeconds((int)$config['seconds']);
                    $room->users()->update(['current_room_score' => 0]);
                    $room->users()->update(['finished_in_room' => false]);
                    $room->save();
                    GameStart::dispatch($room);
                    Timer::dispatch($room)->delay(now()->addMinutes((int)$config['minutes'])->addSeconds((int)$config['seconds']));

                    return response()->json([
                        'message' => 'Game has started.',
                        'status' => 'success',
                    ]);
                }
                else {
                    return response()->json([
                        'message' => "The game is already started.",
                        'status' => 'error',
                    ]);
                }
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
