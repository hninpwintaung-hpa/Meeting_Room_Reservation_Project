<?php

namespace App\Service\Car;

use App\Models\Car;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class CarService implements CarServiceInterface
{
    public function store($data)
    {
        if ($data['car_image'] ?? false) {
            $imageName = time() . '.' . $data['car_image']->extension();
            $data['car_image']->storeAs('public/car_images', $imageName);
            $data['car_image'] = $imageName;
        }
        return Car::create($data);
    }
    public function update($data, $id)
    {
        $car = Car::where('id', $id)->first();

        if ($data['car_image'] ?? false) {
            $imageName = time() . '.' . $data['car_image']->extension();

            if (Storage::exists('public/car_images' . $car->car_image)) {
                Storage::delete('public/car_images' . $car->car_image);
            }
            $data['car_image']->storeAs('public/car_images', $imageName);
            $data['car_image'] = $imageName;
        }

        return $car->update($data);
    }
    public function delete($id)
    {
        $car = Car::where('id', $id)->first();
        if (Storage::exists('public/car_images/' . $car->car_image)) {
            Storage::delete('public/car_images/' . $car->car_image);
        }
        return $car->delete();
    }
}
