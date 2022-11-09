<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return null;
});
Route::get('/events', function () {
    return \Spatie\GoogleCalendar\Event::get();
});
Route::get('/contacts', function () {
    return \SwapnealDev\GoogleContact\Contacts::get();
});

Route::get('/contacts/create', function () {
    return \SwapnealDev\GoogleContact\Contacts::create([
        'first_name' => 'Raju',
        'last_name' => 'Rastogi',
        'mobile' => '9876543210',
        'alternate_mobile' => '9898989898' //this is optional parameter
    ]);
});

//$peopleId is as resourceName like 'people/{string}'
Route::get('/contacts/update', function () {
    return (array) \SwapnealDev\GoogleContact\Contacts::update($peopleId, [
        'first_name' => 'Raju Bhai',
        'last_name' => 'Rastogi',
        'mobile' => '9876543210',
    ]);
});

Route::get('/contacts/delete', function () {
    return \SwapnealDev\GoogleContact\Contacts::delete($peopleId);
});

Route::get('/google-connect', function () {
    return Socialite::driver('google')
        ->scopes([
            'https://www.googleapis.com/auth/calendar.events',
            'https://www.googleapis.com/auth/contacts'
        ])
        ->redirect();
});

Route::get('/google-callback-url', function () {
    $user = Socialite::driver('google')->user();

    $dbUser = User::where('email', $user->email)->first();

    if ($dbUser) {
        $dbUser->google_access_token = $user->token;
        $dbUser->google_calender_id = $user->email;
    } else {
        $dbUser = new User();
        $dbUser->name = $user->name;
        $dbUser->email = $user->email;
        $dbUser->google_access_token = $user->token;
        $dbUser->google_calender_id = $user->email;
        $dbUser->password = \Illuminate\Support\Facades\Hash::make('password');
    }
    $dbUser->save();
    \Illuminate\Support\Facades\Auth::login($dbUser);
    return redirect('/');
});

require __DIR__.'/auth.php';
