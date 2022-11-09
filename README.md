# This is a sample project to implemented [google-calendar](https://github.com/swapneal-dev/laravel-google-calendar-oauth2) & [google-contacts package](https://github.com/swapneal-dev/laravel-google-contacts)

I have used a laravel socialite package for sign in using google.

`All the implementation I have done in web.php file`

Steps to use this project.
1. Clone this project
2. Run migration command
3. Add env variables: 
   1. `GOOGLE_CALENDAR_AUTH_PROFILE=oauth`
   2. `GOOGLE_CLIENT_ID=`
   3. `GOOGLE_CLIENT_SECRET=`
4. Add google end variables in services.php
   ```
   'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => 'http://127.0.0.1:8000/google-callback-url',
    ],
   ```
5. Click on sign-in with Google. allow all the permissions, Then it will redirect to the home.
6. You can see 2 links Events & Contacts.
