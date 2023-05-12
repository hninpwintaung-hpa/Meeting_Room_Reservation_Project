<?php

namespace App\Service\Reservation;

use App\Models\CarReservation;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomReservation;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ReservationService implements ReservationServiceInterface
{
    public function store($data)
    {
        try {
            if (isset($data['room_id'])) {
                if ($data['room_id'] != null) {

                    $reservations = Reservation::all();
                    $inputStartTime = $data['start_time'];
                    $inputEndTime = $data['end_time'];
                    $inputDate = $data['date'];
                    $inputRoom = $data['room_id'];
                    if (empty($reservations)) {
                        return $this->makeRoomReservation($data);
                    }
                    foreach ($reservations as $reservation) {

                        $overlap = $this->checkRoomReservationOverlap($inputStartTime, $inputEndTime, $inputDate, $inputRoom);

                        if ($overlap) {
                            return response()->json(['error' => 'Unable to create reservation.'], 500);
                            exit();
                        } else {
                            return $this->makeRoomReservation($data);
                        }
                    }
                }
            }

            if (isset($data['car_id'])) {
                if ($data['car_id'] != null) {
                    $reservations = Reservation::all();
                    $inputStartTime = $data['start_time'];
                    $inputEndTime = $data['end_time'];
                    $inputDate = $data['date'];
                    $inputCar = $data['car_id'];
                    if (empty($reservations)) {

                        return $this->makeCarReservation($data);
                    }
                    foreach ($reservations as $reservation) {

                        $overlap = $this->checkCarReservationOverlap($inputStartTime, $inputEndTime, $inputDate, $inputCar);
                        if ($overlap) {
                            return response()->json(['error' => 'Unable to create reservation.'], 500);
                            exit();
                        } else {
                            return $this->makeCarReservation($data);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            Log::channel('web_daily_error')->error("Admin Create", [$e->getMessage()]);
            return response()->json(['error' => 'Unable to create reservation.'], 500);
        }
    }

    public function update($data, $id)
    {
        $result = Reservation::where('id', $id)->first();
        if ($data['room_id'] != null) {
            $reservations = Reservation::all();
            $inputStartTime = $data['start_time'];
            $inputEndTime = $data['end_time'];
            $inputDate = $data['date'];
            $inputRoom = $data['room_id'];
            foreach ($reservations as $reservation) {

                $overlap = $this->checkRoomReservationOverlap($inputStartTime, $inputEndTime, $inputDate, $inputRoom);

                if ($overlap) {
                    return response()->json(['error' => 'Unable to update reservation.'], 500);
                    exit();
                } else {
                    return $result->update([
                        'start_time' => $data['start_time'],
                        'end_time' => $data['end_time'],
                        'date' => $data['date'],
                        'user_id' => $data['user_id'],
                        'room_id' => $data['room_id'],
                    ]);
                }
            }
        }

        if ($data['car_id'] != null) {

            $reservations = Reservation::all();
            $inputStartTime = $data['start_time'];
            $inputEndTime = $data['end_time'];
            $inputDate = $data['date'];
            $inputCar = $data['car_id'];
            foreach ($reservations as $reservation) {
                $overlap = $this->checkCarReservationOverlap($inputStartTime, $inputEndTime, $inputDate, $inputCar);

                if ($overlap) {
                    return response()->json(['error' => 'Unable to create reservation.'], 500);
                    exit();
                } else {
                    return $result->update([
                        'start_time' => $data['start_time'],
                        'end_time' => $data['end_time'],
                        'date' => $data['date'],
                        'user_id' => $data['user_id'],
                        'car_id' => $data['car_id'],
                    ]);
                }
            }
        }
    }

    public function delete($id)
    {
        $data = Reservation::where('id', $id)->first();
        return $data->delete();
    }


    public function makeRoomReservation($data)
    {
        return Reservation::create([
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'date' => $data['date'],
            'user_id' => $data['user_id'],
            'room_id' => $data['room_id'],
        ]);
    }

    public function checkRoomReservationOverlap($inputStartTime, $inputEndTime, $inputDate, $inputRoom)
    {
        $overlap = Reservation::where('room_id', $inputRoom)->where('date', '=', $inputDate)->where(function ($query) use ($inputStartTime, $inputEndTime) {
            $query->where(function ($query) use ($inputStartTime, $inputEndTime) {
                $query->where('start_time', '>=', $inputEndTime)
                    ->where('end_time', '<=', $inputStartTime);
            })
                ->orWhere(function ($query) use ($inputStartTime, $inputEndTime) {
                    $query->where('start_time', '<', $inputStartTime)
                        ->where('end_time', '>', $inputEndTime);
                })
                ->orWhere(function ($query) use ($inputStartTime, $inputEndTime) {
                    $query->where('start_time', '>', $inputStartTime)
                        ->where('end_time', '<', $inputEndTime);
                })
                ->orWhere(function ($query) use ($inputStartTime, $inputEndTime) {
                    $query->where('start_time', '<', $inputStartTime)
                        ->where('end_time', '=', $inputEndTime);
                })
                ->orWhere(function ($query) use ($inputStartTime, $inputEndTime) {
                    $query->where('start_time', '=', $inputStartTime)
                        ->where('start_time', '<=', $inputEndTime);
                })

                ->orWhere(function ($query) use ($inputStartTime, $inputEndTime) {
                    $query->where('end_time', '>=', $inputStartTime)
                        ->where('end_time', '=', $inputEndTime);
                });
        })->exists();
        return $overlap;
    }

    public function makeCarReservation($data)
    {
        return Reservation::create([
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'date' => $data['date'],
            'user_id' => $data['user_id'],
            'car_id' => $data['car_id'],
        ]);
    }
    public function checkCarReservationOverlap($inputStartTime, $inputEndTime, $inputDate, $inputCar)
    {
        $overlap = Reservation::where('car_id', $inputCar)->where('date', '=', $inputDate)->where(function ($query) use ($inputStartTime, $inputEndTime) {
            $query->where(function ($query) use ($inputStartTime, $inputEndTime) {
                $query->where('start_time', '>=', $inputEndTime)
                    ->where('end_time', '<=', $inputStartTime);
            })
                ->orWhere(function ($query) use ($inputStartTime, $inputEndTime) {
                    $query->where('start_time', '<', $inputStartTime)
                        ->where('end_time', '>', $inputEndTime);
                })
                ->orWhere(function ($query) use ($inputStartTime, $inputEndTime) {
                    $query->where('start_time', '>', $inputStartTime)
                        ->where('end_time', '<', $inputEndTime);
                })
                ->orWhere(function ($query) use ($inputStartTime, $inputEndTime) {
                    $query->where('start_time', '<', $inputStartTime)
                        ->where('end_time', '=', $inputEndTime);
                })
                ->orWhere(function ($query) use ($inputStartTime, $inputEndTime) {
                    $query->where('start_time', '=', $inputStartTime)
                        ->where('start_time', '<=', $inputEndTime);
                })

                ->orWhere(function ($query) use ($inputStartTime, $inputEndTime) {
                    $query->where('end_time', '>=', $inputStartTime)
                        ->where('end_time', '=', $inputEndTime);
                });
        })->exists();
        return $overlap;
    }
}
