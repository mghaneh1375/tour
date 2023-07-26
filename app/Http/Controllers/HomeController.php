<?php

namespace App\Http\Controllers;

use App\models\Cities;
use App\models\User;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function checkUserNameAndPass()
    {

        if (isset($_POST["username"]) && isset($_POST["pass"]) && isset($_POST["rPass"])) {

            $username = makeValidInput($_POST["username"]);
            $pass = makeValidInput($_POST["pass"]);
            $rPass = makeValidInput($_POST["rPass"]);

            if (User::whereUserName($username)->count() > 0) {
                echo "nok1";
                return;
            }

            if ($pass != $rPass) {
                echo "nok2";
                return;
            }

            $user = new User();
            $user->username = $username;
            $user->password = Hash::make($pass);
            $user->cityId = Cities::first()->id;
            if(request('email') != null && request('phone') != null){
                $user->email = request('email');
                $user->phone = request('phone');
            }
            if(request('firstName') != null && request('lastName') != null){
                $user->first_name = request('firstName');
                $user-> last_name  = request('lastName');
            }

            try {
                $user->save();
                echo "ok";
            } catch (\Exception $x) {
                dd($x);
            }
        }

    }

    function sendPostRequest($url, $data)
    {
        //open connection
        $ch = curl_init();

        $postString = http_build_query($data, '', '&');

//set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
        $result = curl_exec($ch);
        print $result;
        curl_close($ch);
    }


    public function soon()
    {
        return view('errors.underConstruction');
    }

}
