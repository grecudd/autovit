<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "test";
        $user->email = "test@test";
        $user->password = Hash::make("12345678");
        $user->balance = 1000000;
        $user->save();

        $brand = new Brand();
        $brand->name = "Ford";
        $brand->save();

        $model = new CarModel();
        $model->name = "Mustang";
        $model->brand_id = 1;
        $model->save();

        $car = new Car();
        $car->car_model_id = 1;
        $car->brand_id = 1;
        $car->gen = 2018;
        $car->hp = 360;
        $car->km = 80000;
        $car->price = 45000;
        $car->fuel = "benzina";
        $car->user_id = 1;
        $car->save();

        $user = new User();
        $user->name = "test2";
        $user->email = "test2@test2";
        $user->password = Hash::make("12345678");
        $user->balance = 1000000;
        $user->save();
    }
}
