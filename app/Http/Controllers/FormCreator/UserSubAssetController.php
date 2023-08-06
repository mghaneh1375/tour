<?php


namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\models\FormCreator\Asset;
use App\models\FormCreator\Form;
use App\models\FormCreator\FormField;
use App\models\FormCreator\Image;
use App\models\FormCreator\UserFormsData;
use App\models\FormCreator\UserSubAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class UserSubAssetController extends Controller
{

    public function edit_pic_gallery_sub(UserSubAsset $user_sub_asset, FormField $form_field, $curr_file, Request $request) {


        if($request->user()->id != $user_sub_asset->user_id)
            return abort(401);
            
        if(!$user_sub_asset->is_in_form($form_field->id, false, true)) {
            return response()->json([
                "status" => -1
            ]);
        }

        $request->validate([
            "pic" => "image"
        ]);

        $uId = Auth::user()->id;
        $pic = $curr_file;

        $image = Image::wherePath($pic)->first();
        if($image == null) {
            return response()->json([
                "status" => -1
            ]);
        }

        $data = UserFormsData::where('user_id', $uId)->where('field_id', $form_field->id)
            ->where('user_asset_id', $user_sub_asset->id)->where('is_sub_asset', true)->first();

        if($data == null || !in_array($image->id, explode('_', $data->data))) {
            return response()->json([
                "status" => -1
            ]);
        }

        $vals = explode('_', $data->data);
        $find = false;

        foreach ($vals as $itr) {
            if(!$find && $itr == $image->id) {
                $find = true;
                break;
            }
        }

        if(!$find) {
            return response()->json([
                "status" => -1
            ]);
        }

        $path = $request->pic->store('public');

        if(file_exists(__DIR__ . '/../../../../storage/app/public/' . $image->path))
            unlink(__DIR__ . '/../../../../storage/app/public/' . $image->path);

        $image->path = str_replace("public/", "", $path);
        $image->name = ($request->has("name")) ? $request["name"] : null;
        $image->description = ($request->has("description")) ? $request["description"] : null;
        $image->save();

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


    public function delete_pic_from_gallery_sub(UserSubAsset $user_sub_asset, FormField $form_field, Request $request) {

        if($request->user()->id != $user_sub_asset->user_id)
            return abort(401);

        if(!$user_sub_asset->is_in_form($form_field->id, false, true)) {
            return response()->json([
                "status" => -2
            ]);
        }

        $request->validate([
            "pic" => "required"
        ]);

        $uId = Auth::user()->id;
        $data = UserFormsData::where('user_id', $uId)->where('field_id', $form_field->id)
            ->where('user_asset_id', $user_sub_asset->id)->where('is_sub_asset', true)->first();

        if($data == null) {
            return response()->json([
                "status" => -1
            ]);
        }

        $pic = $request["pic"];
        $pic = explode('/', $pic);
        $pic = $pic[count($pic) - 1];

        $image = Image::wherePath($pic)->first();
        if($image == null) {
            return response()->json([
                "status" => -3
            ]);
        }

        $vals = explode('_', $data->data);
        $find = false;
        $newData = "";
        $first = true;

        foreach ($vals as $itr) {
            if(!$find && $itr == $image->id) {
                $find = true;
                if(file_exists(__DIR__ . '/../../../../storage/app/public/' . $pic))
                    unlink(__DIR__ . '/../../../../storage/app/public/' . $pic);
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
                "status" => -4
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
                $out .= URL::asset("storage/" . $image->path);
            }
            else
                $out .= '_' . URL::asset("storage/" . $image->path);
        }

        return response()->json([
            "status" => "0",
            "data" => $out
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param Form $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function sub_asset(Form $form) {

        if($form->asset->super_id == -1) {
            return response()->json([
                "status" => -1
            ]);
        }

        $formIds = Form::where('asset_id', $form->asset_id)->select("id")->get();
        $ids = [];
        $counter = 0;
        foreach ($formIds as $formId)
            $ids[$counter++] = $formId->id;

        return response()->json([
            "status" => 0,
            "subAsset" => Asset::whereId($form->asset_id)->first(),
            "formIds" => $ids
        ]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param UserSubAsset $user_sub_asset
     * @return \Illuminate\Http\JsonResponse
     */
    public static function destroy(UserSubAsset $user_sub_asset, Request $request) {


        if($request->user()->id != $user_sub_asset->user_id)
            return abort(401);

        try {

            DB::transaction(function () use ($user_sub_asset) {

                $userFormsData = UserFormsData::where('user_asset_id', $user_sub_asset->id)->where('is_sub_asset', true)->get();

                foreach ($userFormsData as $itr) {

                    $type = strtolower($itr->form_field->type);

                    if(
                        ($type == "file" && file_exists(__DIR__ . '/../../../../storage/app/' . $itr->data)) ||
                        $type == "gallery"
                    ) {
                        if($type == "file")
                            unlink(__DIR__ . '/../../../../storage/app/' . $itr->data);
                        else {
                            $str = explode('_', $itr->data);
                            foreach ($str as $itrItr) {
                                $tmp = Image::whereId($itrItr)->first();
                                if($tmp != null) {
                                    if(file_exists(__DIR__ . '/../../../../storage/app/' . $tmp->path))
                                        unlink(__DIR__ . '/../../../../storage/app/' . $tmp->path);
                                    $tmp->delete();
                                }
                            }
                        }
                    }

                    $itr->delete();
                }

                $user_sub_asset->delete();

            });

            return response()->json([
                "status" => "0"
            ]);

        }
        catch (\Exception $x) {}

        return response()->json([
            "status" => "-1"
        ]);
    }
}
