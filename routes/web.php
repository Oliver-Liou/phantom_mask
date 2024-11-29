<?php

use App\Models\Pharmacy;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {



    // 測試
    // TODO:增加pharmacy_opening_hours 資料表 pharmacy_id, day_of_week, start_time, end_time 紀錄
    $openingHours = "Mon - Fri 08:00 - 17:00 / Sat, Sun 08:00 - 12:00";
    $parsedHours = Pharmacy::parseOpeningHours($openingHours);

    dd($parsedHours);

    // return view('welcome');
});
