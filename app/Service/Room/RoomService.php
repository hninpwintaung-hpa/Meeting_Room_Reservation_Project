<?php

namespace App\Service\Room;

use App\Models\Room;
use Illuminate\Support\Facades\Storage;

class RoomService implements RoomServiceInterface
{
    public function store($data)
    {
        if ($data['room_image'] ?? false) {
            $imageName = time() . '.' . $data['room_image']->extension();
            $data['room_image']->storeAs('public/room_images', $imageName);
            $data['room_image'] = $imageName;
        }
        return Room::create($data);
    }
    public function update($data, $id)
    {
        $room = Room::where('id', $id)->first();

        if ($data['room_image'] ?? false) {
            $imageName = time() . '.' . $data['room_image']->extension();

            if (Storage::exists('public/room_images' . $room->room_image)) {
                Storage::delete('public/room_images' . $room->room_image);
            }
            $data['room_image']->storeAs('public/room_images', $imageName);
            $data['room_image'] = $imageName;
        }

        return $room->update($data);
    }
    public function delete($id)
    {
        $room = Room::where('id', $id)->first();
        if (Storage::exists('public/room_images/' . $room->room_image)) {
            Storage::delete('public/room_images/' . $room->room_image);
        }
        return $room->delete();
    }
}
