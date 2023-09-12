<?php


namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\models\FormCreator\Asset;
use App\models\FormCreator\FormField;
use App\models\FormCreator\Image;
use App\models\FormCreator\Notification;
use App\models\FormCreator\UserAsset;
use App\models\FormCreator\UserFormsData;
use App\models\FormCreator\UserSubAsset;
use App\Rules\UserSubAssetExist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class UserFormController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param UserAsset $user_asset
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserAsset $user_asset, Request $request) {

        $request->validate([
            "data" => "required|array",
            "data.*.id" => ["bail", "required", "integer", "exists:formDB.form_fields,id"],
            "sub_asset_id" => ['nullable', "exists:formDB.assets,id"],
            "user_sub_asset_id" => ['nullable', new UserSubAssetExist(($request->has("sub_asset_id") ? $request["sub_asset_id"] : -1), true)]
        ]);

        $uId = Auth::user()->_id;
        $userAssetId = $user_asset->id;
        $userSubAsset = null;
        $userSubAssetId = null;

        if($request->has("user_sub_asset_id")) {

            $userSubAssetId = $request["user_sub_asset_id"];

            if($request["user_sub_asset_id"] != -1) {
                $userSubAsset = UserSubAsset::whereId($request["user_sub_asset_id"])->first();
                if($userSubAsset == null) {
                    return response()->json([
                        "status" => -1
                    ]);
                }
            }
        }


        if($userSubAssetId != null) {
            if ($userSubAssetId == -1 && $request->has("sub_asset_id")) {
                $userSubAsset = new UserSubAsset();
                $userSubAsset->user_id = $uId;
                $userSubAsset->asset_id = $request["sub_asset_id"];
                $userSubAsset->user_asset_id = $user_asset->id;
                $userSubAsset->save();

                $userAssetId = $userSubAsset->id;
            }
            else if($userSubAssetId != -1)
                $userAssetId = $userSubAssetId;
        }

        $isSubAsset = ($userSubAssetId != null);
        $formFields = [];
        $errs = [];

        foreach($request['data'] as $d) {

            $id = $d['id'];
            $formField = FormField::whereId($id)->first();
            array_push($formFields, $formField);

            if(!isset($d['data']) || empty($d['data'])) {

                if($formField->necessary) {
                    array_push($errs, ($formField->err == null || empty($formField->err)) ? "داده وارد شده برای فیلد " . $formField->name . " نامعتبر است. " : $formField->err);
                    continue;
                }

            }

            $data = $d["data"];

            if(!$formField->validateData($data)) {
                array_push($errs, ($formField->err == null || empty($formField->err)) ? "داده وارد شده برای فیلد " . $formField->name . " نامعتبر است. " : $formField->err);
                    continue;
            }

            if(!$request->has("user_sub_asset_id") && !$user_asset->is_in_form($id)) {
                return response()->json([
                    "status" => -1
                ]);
            }

            else if($userSubAsset != null && !$userSubAsset->is_in_form($id)) {
                return response()->json([
                    "status" => -1
                ]);
            }

            if(!$formField->validateData($data, true)) {
                array_push($errs, ($formField->err == null || empty($formField->err)) ? "داده وارد شده برای فیلد " . $formField->name . " نامعتبر است. " : $formField->err);
            }

        }

        if(count($errs) > 0) {
            return response()->json([
                "status" => -2,
                "errs" => $errs
            ]);
        }

        $i = -1;

        foreach($request['data'] as $d) {

            $i++;
            $formField = $formFields[$i];
            $id = $d['id'];
            $field = $id;
            $data = $d['data'];

            if($formField->type == 'FILE')
                return abort(401);

            $user_data = UserFormsData::where('field_id',$field)->where('user_id',$uId)->where('user_asset_id',$userAssetId)->firstOr(function () use ($field, $data, $uId, $userAssetId, $isSubAsset) {

                $user_data = new UserFormsData();
                $user_data->field_id = $field;
                $user_data->user_id = $uId;
                $user_data->data = $data;
                $user_data->user_asset_id = $userAssetId;
                $user_data->is_sub_asset = $isSubAsset;
                $user_data->save();
                return null;
                
            });

            if($formField->type == "API") {

                // $apiRes = Http::post($formField->options . "_has_exist", [
                //     "key" => $data
                // ])->json();

                // if($apiRes["status"] == "-1") {
                //     $notification = new Notification();
                //     $notification->msg = "تقاضای افزودن شهر جدید به نام " . $data;
                //     $notification->user_asset_id = $userAssetId;
                //     $notification->save();
                // }
            }

            if($user_data != null) {
                $user_data->data = $data;
                $user_data->save();
            }

        }
        
        return response()->json([
            "status" => 0,
            "id" => $userAssetId
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserSubAsset $user_sub_asset
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSub(UserSubAsset $user_sub_asset, Request $request) {

        $request->validate([
            "id" => ["bail", "required", "exists:formDB.form_fields,id"],
            "sub_sub_asset_id" => ['nullable', "exists:formDB.assets,id"],
            "user_sub_sub_asset_id" => ['nullable', new UserSubAssetExist(($request->has("sub_sub_asset_id") ? $request["sub_sub_asset_id"] : -1), true)]
        ]);

        $formField = FormField::whereId($request["id"])->first();

        if(!$request->has("data") || empty($request["data"])) {

            if($formField->necessary) {
                return response()->json([
                    "status" => -2,
                    "err" => ($formField->err == null || empty($formField->err)) ? "داده وارد شده برای فیلد " . $formField->name . " نامعتبر است. " : $formField->err
                ]);
            }

            return response()->json([
                "status" => 0
            ]);
        }

        if(!$formField->validateData($request["data"])) {
            return response()->json([
                "status" => -2,
                "err" => ($formField->err == null || empty($formField->err)) ? "داده وارد شده برای فیلد " . $formField->name . " نامعتبر است. " : $formField->err
            ]);
        }

        $uId = Auth::user()->_id;

        // if(!$request->has("user_sub_sub_asset_id") && !$user_sub_asset->is_in_form($request["id"])) {
        //    return response()->json([
        //        "status" => -1
        //    ]);
        // }
        // else
         
        if($request->has("user_sub_sub_asset_id")) {
            $userSubSubAsset = UserSubAsset::whereId($request["user_sub_sub_asset_id"])->first();
            if($userSubSubAsset == null || $userSubSubAsset->user_id != $uId ||
                !$userSubSubAsset->is_in_form($request["id"])) {
                return response()->json([
                    "status" => -1
                ]);
            }
        }

        $userSubSubAssetId = null;
        $userSubAssetId = $user_sub_asset->id;

        if($request->has("user_sub_sub_asset_id"))
            $userSubSubAssetId = $request["user_sub_sub_asset_id"];
        else if($request->has("sub_sub_asset_id")) {

            $userSubSubAsset = new UserSubAsset();
            $userSubSubAsset->user_id = $uId;
            $userSubSubAsset->asset_id = $request["sub_sub_asset_id"];
            $userSubSubAsset->user_asset_id = $userSubAssetId;
            $userSubSubAsset->save();

            $userSubSubAssetId = $userSubSubAsset->id;
        }

        $data = $request["data"];
        $field = $request["id"];

        $user_data = UserFormsData::where('field_id',$field)->where('user_id', $uId)->where('user_asset_id',$userSubSubAssetId)->firstOr(function () use ($field, $data, $uId, $userSubSubAssetId) {
            $user_data = new UserFormsData();
            $user_data->field_id = $field;
            $user_data->user_id = $uId;
            $user_data->data = $data;
            $user_data->user_asset_id = $userSubSubAssetId;
            $user_data->is_sub_asset = true;
            $user_data->save();
            return null;
        });

        if($formField->type == "API") {

            $apiRes = Http::post($formField->options . "_has_exist", [
                "key" => $data
            ])->json();

            if($apiRes["status"] == "-1") {
                $notification = new Notification();
                $notification->msg = "تقاضای افزودن شهر جدید به نام " . $data;
                $notification->user_asset_id = $userSubSubAssetId;
                $notification->save();
            }
        }

        if($user_data != null) {
            $user_data->data = $data;
            $user_data->save();
        }

        return response()->json([
            "status" => 0,
            "id" => $userSubSubAssetId
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\models\UserAsset $userAsset
     * @param \App\models\FormField $form_field
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function set_pic(UserAsset $user_asset, FormField $form_field, Request $request) {

        if(!$user_asset->is_in_form($form_field->id, true)) {
            return response()->json([
                "status" => -1
            ]);
        }

        $request->validate([
            "pic" => "image"
        ]);

        $uId = Auth::user()->_id;
        $path = $request->pic->store('public');
        $formFieldId = $form_field->id;
        $userAssetId = $user_asset->id;

        $userFormData = UserFormsData::where('user_id', $uId)->where('field_id',$form_field->id)->where('user_asset_id',$userAssetId)->where('is_sub_asset',false)->firstOr(function () use ($uId, $formFieldId, $path, $userAssetId) {
            $user_data = new UserFormsData();
            $user_data->field_id = $formFieldId;
            $user_data->user_id = $uId;
            $user_data->data = $path;
            $user_data->user_asset_id = $userAssetId;
            $user_data->is_sub_asset = false;
            $user_data->save();
            return null;
        });

        if($userFormData == null) {
            return response()->json([
                "status" => "0"
            ]);
        }

        $oldPath = null;
        if($userFormData->data != null)
            $oldPath = __DIR__ . '/../../../storage/app/public/' . $userFormData->data;

        $userFormData->data = $path;
        $userFormData->save();

        if($oldPath != null && file_exists($oldPath))
            unlink($oldPath);

        return response()->json([
            "status" => "0"
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\models\UserAsset $userAsset
     * @param \App\models\FormField $form_field
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function set_formField_file(UserAsset $user_asset, FormField $form_field, Request $request) {

        $uId = $request->user()->_id;
        if($user_asset->user_id != $uId)
            return abort(401);

        if(!$user_asset->is_in_form($form_field->id, true)) {
            return response()->json([
                "status" => -1
            ]);
        }

        $request->validate([
            "file" => "required|file"
        ]);

        $path = $request->file->store('public');
        $path = str_replace('public/', '', $path);
        $oldPath = null;
        $field = $form_field->id;
        $userAssetId = $user_asset->id;
        $isSubAsset = $user_asset->asset->super_id != -1;

        $user_data = UserFormsData::where('field_id', $field)->where('user_id', $uId)->where('user_asset_id', $userAssetId)->firstOr(function () use ($field, $path, $uId, $userAssetId, $isSubAsset) {
            $user_data = new UserFormsData();
            $user_data->field_id = $field;
            $user_data->user_id = $uId;
            $user_data->data = $path;
            $user_data->user_asset_id = $userAssetId;
            $user_data->is_sub_asset = $isSubAsset;
            $user_data->save();
            return null;
            
        });
        if($user_data != null && $user_asset->data != null) {
            
            $oldPath = __DIR__ . '/../../../storage/app/public/' . $user_asset->data;
            if(file_exists($oldPath))
            unlink($oldPath);
            
            $user_asset->data = $path;
            $user_asset->save();
        }
        
        return response()->json([
            "status" => "0"
        ]);

    }
    public function set_asset_pic(UserAsset $user_asset, FormField $form_field, Request $request) {


        if(!$user_asset->is_in_form($form_field->id, true)) {
            return response()->json([
                "status" => -1
            ]);
        }

        $request->validate([
            "pic" => "image"
        ]);

        $path = $request->pic->store('public');
        $oldPath = null;

        if($user_asset->pic != null)
            $oldPath = __DIR__ . '/../../../storage/app/public/' . $user_asset->pic;

        $user_asset->pic = str_replace("public/", "", $path);
        $user_asset->save();

        if($oldPath != null && file_exists($oldPath))
            unlink($oldPath);

        return response()->json([
            "status" => "0"
        ]);

    }

    public function delete_pic_from_gallery(UserAsset $user_asset, FormField $form_field, Request $request) {

        if(!$user_asset->is_in_form($form_field->id, false, true)) {
            return response()->json([
                "status" => -1
            ]);
        }

        $request->validate([
            "pic" => "required"
        ]);

        $uId = Auth::user()->_id;
        $data = UserFormsData::where('user_id', $uId)->where('field_id', $form_field->id)
            ->where('user_asset_id', $user_asset->id)->where('is_sub_asset', false)->first();

        if($data == null) {
            return response()->json([
                "status" => -1
            ]);
        }

        $pic = $request["pic"];
        $pic = explode('/', $pic);
        $pic = "public/" . $pic[count($pic) - 1];

        $image = Image::wherePath($pic)->first();
        if($image == null) {
            return response()->json([
                "status" => -1
            ]);
        }

        $vals = explode('_', $data->data);
        $find = false;
        $newData = "";
        $first = true;

        foreach ($vals as $itr) {
            if(!$find && $itr == $image->id) {
                $find = true;
                if(file_exists(__DIR__ . '/../../../storage/app/' . $pic))
                    unlink(__DIR__ . '/../../../storage/app/' . $pic);
                $image->delete();
            }
            else {
                if($first) {
                    $newData .= $itr;
                    $first = false;
                }
                else
                    $newData .= "_" . $itr;
            }
        }

        if(!$find) {
            return response()->json([
                "status" => -1
            ]);
        }

        $data->data = $newData;
        $data->save();

        $splited = explode('_', $data->data);
        $out = "";
        $first = true;

        foreach ($splited as $str) {

            $image = Image::whereId($str)->first();

            if($image == null)
                continue;

            if($first) {
                $first = false;
                $out .= URL::asset("storage/" . str_replace('public/', '', $image->path));
            }
            else
                $out .= '_' . URL::asset("storage/" . str_replace('public/', '', $image->path));
        }

        return response()->json([
            "status" => "0",
            "data" => $out
        ]);
    }

    public function add_pic_to_gallery(UserAsset $user_asset, FormField $form_field, Request $request) {

        if(!$user_asset->is_in_form($form_field->id, false, true)) {
            return response()->json([
                "status" => -1
            ]);
        }

        $request->validate([
            "pic" => "image"
        ]);

        $uId = Auth::user()->_id;
        $userAssetId = $user_asset->id;
        $fieldId = $form_field->id;

        $data = UserFormsData::where('user_id', $uId)->where('field_id', $fieldId)
            ->where('user_asset_id', $userAssetId)->where('is_sub_asset', false)
            ->firstOr(function () use ($uId, $fieldId, $userAssetId) {
                $data = new UserFormsData();
                $data->data = '';
                $data->user_asset_id = $userAssetId;
                $data->field_id = $fieldId;
                $data->user_id = $uId;
                $data->is_sub_asset = false;
                $data->save();

                return $data;
            });

        $path = $request->pic->store('public');

        $newImage = new Image();
        $newImage->path = $path;
        $newImage->name = ($request->has("name")) ? $request["name"] : null;
        $newImage->description = ($request->has("description")) ? $request["description"] : null;
        $newImage->save();

        if(empty($data->data))
            $data->data = $newImage->id;
        else
            $data->data .= "_" . $newImage->id;

        $data->save();

        $splited = explode('_', $data->data);
        $out = "";
        $first = true;

        foreach ($splited as $str) {

            $image = Image::whereId($str)->first();

            if($image == null)
                continue;

            if($first) {
                $first = false;
                $out .= URL::asset("storage/" . str_replace('public/', '', $image->path));
            }
            else
                $out .= '_' . URL::asset("storage/" . str_replace('public/', '', $image->path));
        }

        return response()->json([
            "status" => "0",
            "data" => $out
        ]);

    }

    public function add_video_to_gallery(UserAsset $user_asset, FormField $form_field, Request $request) {

        if(!$user_asset->is_in_form($form_field->id, false, true)) {
            return response()->json([
                "status" => -1
            ]);
        }

        if(!$request->has("video")) {
            return response()->json([
                "status" => -2
            ]);
        }

        $file = $request->video;
        $mime = $file->getMimeType();

        if($mime != "video/x-flv" && $mime != "video/mp4" && $mime != "video/quicktime" &&
            $mime != "video/x-msvideo" && $mime != "video/x-ms-wmv") {
            return response()->json([
                "status" => -3
            ]);
        }

        $uId = Auth::user()->_id;
        $userAssetId = $user_asset->id;
        $fieldId = $form_field->id;

        $data = UserFormsData::where('user_id', $uId)->where('field_id', $fieldId)
            ->where('user_asset_id', $userAssetId)->where('is_sub_asset', false)
            ->firstOr(function () use ($uId, $fieldId, $userAssetId) {
                $data = new UserFormsData();
                $data->data = '';
                $data->user_asset_id = $userAssetId;
                $data->field_id = $fieldId;
                $data->user_id = $uId;
                $data->is_sub_asset = false;
                $data->save();

                return $data;
            });

        $path = $request->video->store('public');

        $newImage = new Image();
        $newImage->path = $path;
        $newImage->name = ($request->has("name")) ? $request["name"] : null;
        $newImage->description = ($request->has("description")) ? $request["description"] : null;
        $newImage->save();

        if(empty($data->data))
            $data->data = $newImage->id;
        else
            $data->data .= "_" . $newImage->id;

        $data->save();

        $splited = explode('_', $data->data);
        $out = "";
        $first = true;

        foreach ($splited as $str) {

            $image = Image::whereId($str)->first();

            if($image == null)
                continue;

            if($first) {
                $first = false;
                $out .= URL::asset("storage/" . str_replace('public/', '', $image->path));
            }
            else
                $out .= '_' . URL::asset("storage/" . str_replace('public/', '', $image->path));
        }

        return response()->json([
            "status" => "0",
            "data" => $out
        ]);

    }

    public function add_pic_to_gallery_sub(UserAsset $user_asset, FormField $form_field, Asset $sub_asset, $user_sub_asset_id, Request $request) {

        $uId = Auth::user()->_id;

        $request->validate([
            "pic" => "image"
        ]);

        $userSubAsset = null;

        if($user_sub_asset_id == -1) {
            $userSubAsset = new UserSubAsset();
            $userSubAsset->user_id = $uId;
            $userSubAsset->asset_id = $sub_asset->id;
            $userSubAsset->user_asset_id = $user_asset->id;
            $userSubAsset->save();
            $user_sub_asset_id = $userSubAsset->id;
        }
        else
            $userSubAsset = UserSubAsset::whereId($user_sub_asset_id)
                ->where('user_id', $uId)
                ->where('asset_id', $sub_asset->id)->first();

        if($userSubAsset == null) {
            return response()->json([
                "status" => -1
            ]);
        }

        if(!$userSubAsset->is_in_form($form_field->id, false, true)) {

            if($user_sub_asset_id == -1)
                $userSubAsset->delete();

            return response()->json([
                "status" => -1
            ]);
        }

        $fieldId = $form_field->id;

        $data = UserFormsData::where('user_id', $uId)->where('field_id', $fieldId)
            ->where('user_asset_id', $user_sub_asset_id)->where('is_sub_asset', true)
            ->firstOr(function () use ($uId, $fieldId, $user_sub_asset_id) {
                $data = new UserFormsData();
                $data->user_id = $uId;
                $data->user_asset_id = $user_sub_asset_id;
                $data->data = "";
                $data->field_id = $fieldId;
                $data->is_sub_asset = true;
                $data->save();

                return $data;
            });

        $path = $request->pic->store('public');

        $newImage = new Image();
        $newImage->path = str_replace("public/", "", $path);
        $newImage->name = ($request->has("name")) ? $request["name"] : null;
        $newImage->description = ($request->has("description")) ? $request["description"] : null;
        $newImage->save();

        if(empty($data->data))
            $data->data = $newImage->id;
        else
            $data->data .= "_" . $newImage->id;

        $data->save();

        $splited = explode('_', $data->data);
        $out = "";
        $first = true;

        foreach ($splited as $str) {

            $image = Image::whereId($str)->first();

            if($image == null)
                continue;

            if($first) {
                $first = false;
                $out .= URL::asset("storage/" . str_replace('public/', '', $image->path));
            }
            else
                $out .= '_' . URL::asset("storage/" . str_replace('public/', '', $image->path));
        }

        return response()->json([
            "status" => "0",
            "data" => $out,
            "id" => $user_sub_asset_id
        ]);

    }

    public function add_video_to_gallery_sub(UserAsset $user_asset, FormField $form_field, Asset $sub_asset, $user_sub_asset_id, Request $request) {

        $uId = Auth::user()->_id;

        if(!$request->has("video")) {
            return response()->json([
                "status" => -2
            ]);
        }

        $file = $request->video;
        $mime = $file->getMimeType();

        if($mime != "video/x-flv" && $mime != "video/mp4" && $mime != "video/quicktime" &&
            $mime != "video/x-msvideo" && $mime != "video/x-ms-wmv") {
            return response()->json([
                "status" => -3
            ]);
        }

        $userSubAsset = null;

        if($user_sub_asset_id == -1) {
            $userSubAsset = new UserSubAsset();
            $userSubAsset->user_id = $uId;
            $userSubAsset->asset_id = $sub_asset->id;
            $userSubAsset->user_asset_id = $user_asset->id;
            $userSubAsset->save();
            $user_sub_asset_id = $userSubAsset->id;
        }
        else
            $userSubAsset = UserSubAsset::whereId($user_sub_asset_id)->where('user_id', $uId)->where('asset_id', $sub_asset->id)->first();

        if($userSubAsset == null) {
            return response()->json([
                "status" => -1
            ]);
        }

        if(!$userSubAsset->is_in_form($form_field->id, false, true)) {

            if($user_sub_asset_id == -1)
                $userSubAsset->delete();

            return response()->json([
                "status" => -1
            ]);
        }

        $fieldId = $form_field->id;

        $data = UserFormsData::where('user_id', $uId)->where('field_id', $fieldId)
            ->where('user_asset_id', $user_sub_asset_id)->where('is_sub_asset', true)
            ->firstOr(function () use ($uId, $fieldId, $user_sub_asset_id) {
                $data = new UserFormsData();
                $data->user_id = $uId;
                $data->user_asset_id = $user_sub_asset_id;
                $data->data = "";
                $data->field_id = $fieldId;
                $data->is_sub_asset = true;
                $data->save();

                return $data;
            });

        $path = $request->video->store('public');

        $newImage = new Image();
        $newImage->path = str_replace("public/", "", $path);
        $newImage->name = ($request->has("name")) ? $request["name"] : null;
        $newImage->description = ($request->has("description")) ? $request["description"] : null;
        $newImage->save();

        if(empty($data->data))
            $data->data = $newImage->id;
        else
            $data->data .= "_" . $newImage->id;

        $data->save();

        $splited = explode('_', $data->data);
        $out = "";
        $first = true;

        foreach ($splited as $str) {

            $image = Image::whereId($str)->first();

            if($image == null)
                continue;

            if($first) {
                $first = false;
                $out .= URL::asset("storage/" . str_replace('public/', '', $image->path));
            }
            else
                $out .= '_' . URL::asset("storage/" . str_replace('public/', '', $image->path));
        }

        return response()->json([
            "status" => "0",
            "data" => $out,
            "id" => $user_sub_asset_id
        ]);

    }

    public function edit_pic_gallery(UserAsset $user_asset, FormField $form_field, $curr_file, Request $request) {

        if(!$user_asset->is_in_form($form_field->id, false, true)) {
            return response()->json([
                "status" => -1
            ]);
        }

        $request->validate([
            "pic" => "image"
        ]);

        $uId = Auth::user()->_id;
        $pic = "public/" . $curr_file;

        $image = Image::wherePath($pic)->first();
        if($image == null) {
            return response()->json([
                "status" => -1
            ]);
        }

        $data = UserFormsData::where('user_id', $uId)->where('field_id', $form_field->id)
            ->where('user_asset_id', $user_asset->id)->where('is_sub_asset', false)->first();

        if($data == null || !in_array($image->id, explode('_', $data->data))) {
            return response()->json([
                "status" => -1
            ]);
        }

        $vals = explode('_', $data->data);
        $find = false;
        $newData = "";
        $first = true;

        foreach ($vals as $itr) {
            if(!$find && $itr == $image->id)
                $find = true;
            else {
                if($first) {
                    $newData .= $itr;
                    $first = false;
                }
                else
                    $newData .= "_" . $itr;
            }
        }

        if(!$find) {
            return response()->json([
                "status" => -1
            ]);
        }

        $path = $request->pic->store('public');

        if(file_exists(__DIR__ . '/../../../storage/app/' . $image->path))
            unlink(__DIR__ . '/../../../storage/app/' . $image->path);

        $image->delete();

        $image = new Image();
        $image->path = $path;
        $image->name = ($request->has("name")) ? $request["name"] : null;
        $image->description = ($request->has("description")) ? $request["description"] : null;
        $image->save();

        if(empty($newData))
            $newData = $image->id;
        else
            $newData .= "_" . $image->id;

        $data->data = $newData;
        $data->save();

        $splited = explode('_', $newData);
        $out = "";
        $first = true;

        foreach ($splited as $str) {

            $image = Image::whereId($str)->first();

            if($image == null)
                continue;

            if($first) {
                $first = false;
                $out .= URL::asset("storage/" . str_replace('public/', '', $image->path));
            }
            else
                $out .= '_' . URL::asset("storage/" . str_replace('public/', '', $image->path));
        }

        return response()->json([
            "status" => "0",
            "data" => $out
        ]);

    }

}
