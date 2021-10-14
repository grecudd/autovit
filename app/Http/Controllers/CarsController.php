<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarModel;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $builder = Car::query();

        if ($request->brand) {
            $builder->whereHas('carModel', function ($query) use ($request) {
                $query->whereHas('brand', function ($query) use ($request) {
                    $query->where(strtolower('name'), strtolower($request->brand));
                });
            });
        }

        if ($request->model) {
            $builder->whereHas('carModel', function ($query) use ($request) {
                $query->where(strtolower('name'), strtolower($request->model));
            });
        }

        if ($request->kmMin) {
            $builder->where('km', '>=', $request->kmMin);
        }

        if ($request->kmMax) {
            $builder->where('km', '<=', $request->kmMax);
        }

        if ($request->priceMin) {
            $builder->where('price', '>=', $request->priceMin);
        }

        if ($request->priceMax) {
            $builder->where('price', '<=', $request->priceMax);
        }

        if ($request->genMin) {
            $builder->where('gen', '>=', $request->genMin);
        }

        if ($request->genMax) {
            $builder->where('gen', '<=', $request->genMax);
        }

        $cars = $builder
            ->where('avalability', true)
            ->get();

        return view('index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('add_car');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'gen' => 'required',
            'hp' => 'required',
            'km' => 'required',
            'price' => 'required',
            'fuel' => 'required',
            'image' => 'required|mimes:jpg,png,jped'
        ]);

        $newImageName = time() . '-' . $request->brand . '-' . $request->model . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $newImageName);

        $brand = new Brand();
        $brand->name = $request->brand;
        $brand->save();

        $model = new CarModel();
        $model->name = $request->model;
        $model->brand_id = $brand->id;
        $model->save();

        $insert = new Car();
        $insert->brand_id = $model->id;
        $insert->car_model_id = $brand->id;
        $insert->gen = $request->gen;
        $insert->hp = $request->hp;
        $insert->km = $request->km;
        $insert->price = $request->price;
        $insert->fuel = $request->fuel;
        $insert->user_id = Auth::user()->id;
        $insert->image_path = $newImageName;
        $insert->save();

        session()->flash('car_added', 'Car added successfully');
        return redirect()->route('cars.dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $brand = Brand::findOrFail($car->brand_id);
        $brand->name = $request->brand;
        $brand->save();

        $model = CarModel::findOrFail($car->car_model_id);
        $model->name = $request->model;
        $model->save();

        if ($request->image != null) {
            $request->validate([
                'image' => 'required|mimes:jpg,png,jped'
            ]);
            if ($car->image_path != 'null') {
                $deleteImage = 'images/' . $car->image_path;
                //unlink($deleteImage);
            }

            $newImageName = time() . '-' . $request->brand . '-' . $request->model . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $newImageName);
            $car->image_path = $newImageName;
        }


        $car->gen = $request->gen;
        $car->hp = $request->hp;
        $car->km = $request->km;
        $car->price = $request->price;
        $car->fuel = $request->fuel;
        $car->save();

        session()->flash('car_update', 'Car updated successfully');
        return view('show', compact('car'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();
        session()->flash('car_deleted', 'Car deleted successfully');
        return redirect()->route('cars.dashboard');
    }

    public function dashboard()
    {
        $id = Auth::user()->id;
        $cars = Car::where('user_id', $id)
            ->where('avalability', false)->get();
        $listedCars = Car::where('user_id', $id)
            ->where('avalability', true)->get();

        return view('dashboard', compact('cars', 'listedCars'));
    }

    public function logOut(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function buy($id)
    {
        $car = Car::findOrFail($id);
        return view('buy', compact('car'));
    }

    public function validateBuy($id)
    {

        $user = User::findOrFail(Auth::user()->id);
        $car = Car::findOrFail($id);
        $price = $car->price;

        if ($user->balance >= $price) {
            $car->bought_user_id = 0;

            $car->avalability = false;
            $user->balance -= $price;
            $user->save();

            $user = User::findOrFail($car->user_id);
            $user->balance += $price;
            $user->save();

            $car->user_id = Auth::user()->id;
            $car->save();
            session()->flash('buy_validated', $car->brand . ' bought sucessfully');
        } else {
            session()->flash('buy_error', 'Buy error');
        }
        return redirect()->route('cars.dashboard');
    }

    public function list($id)
    {
        $car = Car::findOrFail($id);
        if ($car->avalability == true) {
            $car->avalability = false;
            session()->flash('car_avalability', 'Car unlisted');
        } else {
            $car->avalability = true;
            session()->flash('car_avalability', 'Car listed');
        }
        $car->save();
        return redirect()->route('cars.dashboard');
    }
}
