<?php

use Illuminate\Support\Facades\Route;
use Twilio\Rest\Client;

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

    $sid    = "AC5048b9418226346a301b3050f4090bdf";
    $token  = "46cc768d184db7d1d62f468c1e588866";
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
        ->create("+380663912460", // to
            array(
                "from" => "+12092271414",
                "body" => "Your Message"
            )
        );
});
