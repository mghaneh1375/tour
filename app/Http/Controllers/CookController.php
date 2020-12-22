<?php

namespace App\Http\Controllers;

use App\models\ActivationCode;
use App\models\DefaultPic;
use App\models\festival\FestivalCookImage;
use App\models\FestivalLimboContent;
use App\models\places\MahaliFood;
use App\User;
use Illuminate\Http\Request;

class CookController extends Controller
{
    public function cookFestival()
    {
        return view('pages.festival.cookFestival.mainCookFestivalPage');
    }

    public function checkFirstStepRegister(Request $request)
    {
        if(!auth()->check()){
            if(isset($request->username) && isset($request->phone)){
                $phoneNumber = convertNumber('en', $request->phone);
                $checkUsername = User::where('username', $request->username)->first();
                $checkPhone = User::where('phone', $phoneNumber)->first();
                $errors = [];

                if($checkPhone != null)
                    array_push($errors, 'شماره وارد شده در سامانه قبلا ثبت شده است');
                if($checkUsername != null)
                    array_push($errors, 'نام کاربری وارد شده تکراری می باشد');

                if(count($errors) == 0){
                    $sendSms = false;
                    $activationCode = ActivationCode::where('phoneNum', $phoneNumber)->first();
                    $code = createCode();

                    if($activationCode == null) {
                        $activationCode = new ActivationCode();
                        $sendSms = true;
                    }
                    else if(time() > $activationCode->sendTime+90)
                        $sendSms = true;
                    else
                        return response()->json(['status' => 'remaining', 'result' => ( ( $activationCode->sendTime + 90 ) - time() )]);

                    if($sendSms){
                        $msgId = sendSMS($phoneNumber, $code, 'sms');
                        if ($msgId == -1)
                            return response()->json(['status' => 'smsError']);
                    }

                    $activationCode->phoneNum = $phoneNumber;
                    $activationCode->sendTime = time();
                    $activationCode->code = $code;
                    $activationCode->save();
                    return response()->json(['status' => 'ok', 'result' => 90]);
                }
                else
                    return response()->json(['status' => 'error2', 'result' => $errors]);
            }
            else
                return response()->json(['status' => 'error1']);
        }
        else
            return response()->json(['status' => 'auth']);
    }

    public function fullRegister(Request $request){
        if(!auth()->check()){
//            isset($request->firstName) && isset($request->lastName) &&
            if( isset($request->phone) && isset($request->userName) && isset($request->password) && isset($request->activationCode)){
//                $firstName = $request->firstName;
//                $lastName = $request->lastName;
                $phone = $request->phone;
                $userName = $request->userName;
                $password = $request->password;
                $activationCode = $request->activationCode;
                $errors = [];

                $phone = convertNumber('en', $phone);
                $checkUsername = User::where('username', $userName)->first();
                $checkPhone = User::where('phone', $phone)->first();
                $checkActivationCode = ActivationCode::where('phoneNum', $phone)
                                                    ->where('code', $activationCode)
                                                    ->first();
                if($checkPhone != null)
                    array_push($errors, 'شماره وارد شده در سامانه قبلا ثبت شده است');
                if($checkUsername != null)
                    array_push($errors, 'نام کاربری وارد شده تکراری می باشد');

                if(count($errors) == 0){
                    if($checkActivationCode == null)
                        return response()->json(['status' => 'error3']);

                    $uInvitationCode = generateRandomString(6);
                    while (\App\models\User::whereInvitationCode($uInvitationCode)->count() > 0)
                        $uInvitationCode = generateRandomString(6);

                    $user = new User();
//                    $user->first_name = $firstName;
//                    $user->last_name = $lastName;
                    $user->username = $userName;
                    $user->phone = $phone;
                    $user->password = \Hash::make($password);
                    $user->level = 0;
                    $user->invitationCode = $uInvitationCode;
                    $user->picture = DefaultPic::inRandomOrder()->first()->id;
                    $user->save();
                    createWelcomeMsg($user->id);
                    \Auth::loginUsingId($user->id);
                    $checkActivationCode->delete();
                    return response()->json(['status' => 'ok']);
                }
                else
                    return response()->json(['status' => 'error2', 'result' => $errors]);
            }
            else
                return response()->json(['status' => 'error1']);
        }
        else
            return response()->json(['status' => 'auth']);
    }

    public function uploadFile(Request $request)
    {
        $user = auth()->user();
        $direction = __DIR__.'/../../../../assets/_images/festival';
        if(!is_dir($direction))
            mkdir($direction);

        $direction .= '/limbo';
        if(!is_dir($direction))
            mkdir($direction);

        if(isset($request->cancelUpload) && $request->cancelUpload == 1){
            $direction .= '/'.$request->storeFileName;
            if(is_file($direction))
                unlink($direction);
            FestivalCookImage::where('userId', $user->id)
                                ->where('file', $request->storeFileName)
                                ->delete();
            return response()->json(['status' => 'canceled']);
        }

        if(isset($request->file_data)){
            if(isset($request->storeFileName) && $request->storeFileName != 0){
                $fileName = $request->storeFileName;
                $direction .= '/'.$fileName;
                $result = uploadLargeFile($direction, $request->file_data);
            }
            else{
                $file_name = $request->file_name;
                $fileType = explode('.', $file_name);
                $fileName = time().rand(100, 999).'_'.$user->id.'.'.end($fileType);
                $direction .= '/'.$fileName;
                $result = uploadLargeFile($direction, $request->file_data);
                if($result) {
                    $limbo = new FestivalCookImage();
                    $limbo->userId = $user->id;
                    $limbo->file = $fileName;
                    $limbo->type = strpos($request->file_type, 'video') !== false ? 'video' : 'image';
                    $limbo->save();
                }
            }

            if($result)
                return response()->json(['status' => 'ok', 'fileName' => $fileName]);
            else
                return response()->json(['status' => 'nok']);
        }
        else if(isset($request->thumbnail) && $request->thumbnail != ''){
            $cookImg = FestivalCookImage::where('file', $request->fileName)->where('userId', auth()->user()->id)->first();
            if($cookImg != null) {
                $fileName = explode('.', $request->fileName);
                $fileName = 'thumb_' . $fileName[0] . '.png';

                $direction .= '/'.$fileName;
                $result = uploadLargeFile($direction, $request->thumbnail);

                if ($result) {
                    $cookImg->thumbnail = $fileName;
                    $cookImg->save();
                    return response()->json(['status' => 'ok']);
                }
                else
                    return response()->json(['status' => 'error3']);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function deleteFile(Request $request)
    {
        if(isset($request->fileName)){
            $direction = __DIR__.'/../../../../assets/_images/festival/limbo';

            $user = auth()->user();
            $file = FestivalCookImage::where('file', $request->fileName)->where('userId', $user->id)->first();
            if($file != null){
                if($file->type == 'video' && is_file($direction.'/'.$file->thumbnail))
                        unlink($direction.'/'.$file->thumbnail);

                $file->delete();
            }
            if(is_file($direction.'/'.$request->fileName))
                unlink($direction.'/'.$request->fileName);

            return response()->json(['status' => 'ok']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function submitFiles(Request $request)
    {
        $fileNames = json_decode($request->filesName);
        $foodInput = json_decode($request->food);
        $user = auth()->user();
        $foodId = 0;
        $foodName = '';

        $direction = __DIR__.'/../../../../assets/_images/festival/';
        $cookDir = $direction.'cook';
        $limboDir = $direction.'limbo';

        if(!is_dir($cookDir))
            mkdir($cookDir);

        if($foodInput->id != 0){
            $food = MahaliFood::find($foodInput->id);
            if($food != null)
                $foodId = $food->id;
            else if($foodInput->name != '')
                $foodName = $foodInput->name;
            else
                return response()->json('error2');
        }
        else if($foodInput->name != '')
            $foodName = $foodInput->name;
        else
            return response()->json('error2');


        foreach ($fileNames as $name){
            $cookPic = FestivalCookImage::where('file', $name)->where('userId', $user->id)->where('isLimbo', 1)->first();
            if($cookPic != null){
                if(is_file($limboDir.'/'.$name))
                    rename($limboDir.'/'.$name, $cookDir.'/'.$name);
                if($cookPic->thumbnail != null && is_file($limboDir.'/'.$cookPic->thumbnail))
                    rename($limboDir.'/'.$cookPic->thumbnail, $cookDir.'/'.$cookPic->thumbnail);
            }
            else{
                if(is_file($limboDir.'/'.$name)) {
                    rename($limboDir . '/' . $name, $cookDir . '/' . $name);
                    $cookPic = new FestivalCookImage();
                    $cookPic->userId = $user->id;
                    $cookPic->file = $name;
                    $cookPic->confirm = 0;
                    $cookPic->type = "image";

                    try {
                        $thumbnail = explode('.', $name);
                        $thumbnail = "thumb_$thumbnail[0].png";
                        if (is_file($limboDir.'/'.$thumbnail)) {
                            rename($limboDir . '/' . $thumbnail, $cookDir . '/' . $thumbnail);
                            $cookPic->thumbnail = $thumbnail;
                            $cookPic->type = "video";
                        }
                    }
                    catch (\Exception $exception){}
                }
                else
                    continue;
            }

            if($foodId != 0)
                $cookPic->foodId = $foodId;
            else
                $cookPic->foodName = $foodName;
            $cookPic->isLimbo = 0;
            $cookPic->save();
        }

        return response()->json('ok');
    }
}
