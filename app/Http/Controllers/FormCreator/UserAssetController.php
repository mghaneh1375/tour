<?php

namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAssetDigest;
use App\models\FormCreator\Asset;
use App\models\FormCreator\Form;
use App\models\FormCreator\Image;
use App\models\FormCreator\UserAsset;
use App\models\FormCreator\UserFormsData;
use App\models\FormCreator\UserSubAsset;
use App\models\Ticket;
use App\Rules\InForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class UserAssetController extends Controller
{

//    public function __construct()
//    {
//        $this->authorizeResource(UserAsset::class);
//    }

    /**
     * Display a listing of the resource.
     *
     * @param Asset $asset
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Asset $asset) {
        return response()->json([
            "status" => "0",
            "assets" => UserAssetDigest::collection($asset->user_assets()->where('user_id', Auth::user()->id)->get())
        ]);
    }
    public function all(Request $request) {
        
        $assets = Asset::all();
        $output = [];
        $uId = Auth::user()->id;
        
        foreach($assets as $asset) {
            
            $userAssets = $asset->user_assets()->where('user_id', $uId)->get();
            
            if(count($userAssets) == 0)
                continue;

            $tmp = UserAssetDigest::collection($userAssets)->toArray($request);
            $arr = [];
            
            foreach($tmp as $itr) {
                $itr['asset'] = $asset->name;
                $itr['asset_id'] = $asset->id;
                array_push($arr, $itr);
            }

            array_push($output, $arr);
        }

        return response()->json([
            "status" => "0",
            "assets" => $output
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Asset $asset
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Asset $asset, Request $request){
        
        $form_fields = $asset->forms()->where("step", 1)->first()->form_fields()->select("id")->get();

        $request->validate([
            "id" => ["required", "exists:formDB.form_fields,id", new InForm($form_fields)],
            "data" => ["required"]
        ]);

        $title = $request["data"];
        $user = Auth::user();

        // $token = self::createToken();

        // $apiRes = Http::asForm()->withoutVerifying()->post(self::$apiBaseUrl . "addUser", [
        //     "token" => $token[0],
        //     "time" => $token[1],
        //     "data" => $title,
        //     "parentUsername" => $user->name,
        // ]);

        // if(!$apiRes->successful()) {
        //     return response()->json([
        //         "status" => "-1",
        //         "err" => "نام انتخابی شما در سیستم موجود است."
        //     ]);
        // }

        // $apiRes = $apiRes->json();
        // if(!isset($apiRes["status"]) || $apiRes["status"] != "0") {
        //     return response()->json([
        //         "status" => "-1",
        //         "err" => "نام انتخابی شما در سیستم موجود است."
        //     ]);
        // }

        $user_asset = new UserAsset();
        $user_asset->asset_id = $asset->id;
        $user_asset->user_id = $user->id;
        $user_asset->title = $title;

        $user_asset->save();

        return response()->json([
            "status" => "0", "id" => $user_asset->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\UserAsset  $userAsset
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(UserAsset $user_asset) {
        
        $asset = $user_asset->asset;
        $forms = $asset->forms()->where("step", ">", 1)->get();
        $userId = $user_asset->user_id;

        foreach ($forms as $form) {

            $isSubAsset = ($form->asset->super_id != -1);
            
            if($isSubAsset) {
                $tmp = UserSubAsset::where('user_id', $userId)->where('asset_id', $form->asset->id)->where('user_asset_id', $user_asset->id)->first();
                $userAssetId = ($tmp == null) ? -1 : $tmp->id;
            }
            else
                $userAssetId = $user_asset->id;

            $form->fields = $form->form_fields()->where("type", "!=", "REDIRECTOR")->leftJoin("user_forms_data", function ($join) use ($userId, $isSubAsset, $userAssetId) {
                $join->on("form_fields.id", "=", "field_id")->where('user_id', $userId)->where('is_sub_asset', $isSubAsset)->where('user_asset_id', $userAssetId);
            })->select(['user_forms_data.id', 'err_text', 'name', 'type', 'options', 'data', 'status'])->get();
            
            foreach($form->fields as $itr) {

                if(isset($itr->id))
                    $itr->update_status_url = route('setFieldStatus', ['user_form_data' => $itr->id]);


                if($itr->type == "LISTVIEW") {

                    $isSubAsset = ($form->asset->super_id != -1);
                    $userSubAsset = null;
                    $userAsset = null;

                    if ($isSubAsset) {
                        $userSubAsset = UserSubAsset::where('id',$userAssetId)->first();
                        if ($userSubAsset == null)
                            continue;
                    }
                    else {
                        $userAsset = UserAsset::where('id',$userAssetId)->first();
                        if ($userAsset == null)
                            continue;
                    }
    
                    if($isSubAsset) {
                        if($userSubAsset == null)
                            $subAssets = [];
                        else
                            $subAssets = UserSubAsset::where('user_id',$userId)->where('asset_id',$itr->options[0])->where('user_asset_id',$userSubAsset->id)->select("id")->get();
                    }
                    else
                        $subAssets = UserSubAsset::where('user_id',$userId)->where('asset_id', $itr->options[0])->where('user_asset_id',$userAsset->id)->select("id")->get();
    
                        // todo: thinking pic = false
                    $pic = true;
    
                    foreach ($subAssets as $subAsset) {
    
                        $subAsset->fields = DB::connection("formDB")->select("select lower(ff.type) as type from assets a, forms f, form_fields ff, user_forms_data u where " .
                            " ff.presenter = 1 and ff.id = u.field_id and a.id = f.asset_id and u.is_sub_asset = true and f.id = ff.form_id and" .
                            " u.user_asset_id = " . $subAsset->id
                        );
    
                        foreach ($subAsset->fields as $ff) {
                            if($ff->type == "file") {
                                $pic = true;
                                break;
                            }
                            else if($ff->type == "gallery") {
                                $pic = true;
                                break;
                            }
                        }
                        break;
                    }

                    if($pic) {
                        foreach ($subAssets as $subAsset) {
    
                            $subAsset->fields = DB::connection("formDB")->select("select lower(ff.type) as type, ff.name as key_, u.data as val from assets a, forms f, form_fields ff, user_forms_data u where " .
                                " ff.presenter = 1 and ff.id = u.field_id and a.id = f.asset_id and u.is_sub_asset = true and f.id = ff.form_id and" .
                                " u.user_asset_id = " . $subAsset->id
                            );
    
                            foreach ($subAsset->fields as $ff) {
                                if ($ff->type == "file")
                                    $ff->val = asset("storage/" . str_replace('public/', '', $ff->val));
                                else if ($ff->type == "gallery") {
    
                                    $images = explode('_', $ff->val);
                                    $vals = [];
    
                                    foreach($images as $image) {
                                        $img = Image::whereId($image)->first();
                                        if ($img == null)
                                            array_push($vals, URL::asset('../storage/default.png'));
                                        else
                                            array_push($vals, URL::asset("storage/" . $img->path));
                                    }
                                    
                                    $ff->val = $vals;
                                }
                            }
                        }
                    }
                    else {
    
                        $supers = [];
                        $counter1 = 0;
    
                        foreach ($subAssets as $subAsset) {
    
                            $subAsset->fields = DB::connection("formDB")->select("select ff.placeholder, ff.name as key_, u.data as val, f.name as superKey from".
                                " assets a, forms f, form_fields ff, user_forms_data u where " .
                                " ff.presenter = 1 and ff.id = u.field_id and a.id = f.asset_id and u.is_sub_asset = true and f.id = ff.form_id and" .
                                " u.user_asset_id = " . $subAsset->id ." order by ff.id asc"
                            );
    
                            $output = [];
                            $counter2 = 0;
    
                            foreach ($subAsset->fields as $ff) {
                                if(array_search($ff->superKey, $supers) == false) {
                                    $supers[$counter1++] = $ff->superKey;
                                    $output[$counter2++] = ["type" => "super", "key_" => $ff->superKey, "val" => $ff->superKey];
                                }
                            }
    
                            foreach ($subAsset->fields as $ff) {
                                if(strpos($ff->placeholder, "تومان") !== false)
                                    $output[$counter2++] = ["type" => $ff->superKey, "key_" => $ff->key_, "val" => $ff->val . " تومان"];
                                else
                                    $output[$counter2++] = ["type" => $ff->superKey, "key_" => $ff->key_, "val" => $ff->val];
                            }
    
                            $subAsset->fields = $output;
                        }
    
                    }
    
                    $itr->items = $subAssets;
                }
                           
            }
        }

        dd($forms);

        return view('formCreator.report.field', [
            'forms' => $forms, 
            'id' => $user_asset->id, 
            'status' => $user_asset->status,
            'err_text' => $user_asset->err_text
        ]);
    }


    /**
     * Set status of specified resource.
     *
     * @param  \App\models\UserFormsData $user_form_data
     */
    public function setFieldStatus(UserFormsData $user_form_data, Request $request) {

        $request->validate([
            'status' => ['required', Rule::in(['REJECT', 'CONFIRM', 'PENDING'])],
            'err_text' => 'nullable|string|min:2'
        ]);

        $user_form_data->status = $request['status'];
        
        if($request['status'] == 'REJECT' && $request->has('err_text'))
            $user_form_data->err_text = $request['err_text'];

        $user_form_data->save();

        return response(['status' => '0']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\UserAsset  $userAsset
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserAsset $user_asset, Request $request) {

        $request->validate([
            "data" => "required"
        ]);

        $title = $request["data"];

        if($user_asset->title == $title) {
            return response()->json([
                "status" => "0"
            ]);
        }

        // $token = self::createToken();
        // $apiRes = Http::asForm()->withoutVerifying()->post(self::$apiBaseUrl . "updateUserName", [
        //     "token" => $token[0],
        //     "time" => $token[1],
        //     "oldUsername" => $userAsset->title,
        //     "newUsername" => $title
        // ]);

        // if(!$apiRes->successful()) {
        //     return response()->json([
        //         "status" => "-1",
        //         "err" => "نام انتخابی شما در سیستم موجود است."
        //     ]);
        // }

        // $apiRes = $apiRes->json();
        // if(!isset($apiRes["status"]) || $apiRes["status"] != "0") {
        //     return response()->json([
        //         "status" => "-1",
        //         "err" => "نام انتخابی شما در سیستم موجود است."
        //     ]);
        // }

        $user_asset->title = $title;
        $user_asset->save();

        return response()->json([
            "status" => "0"
        ]);

    }

    private function hasUserAnswerToThisField($userFormsData, $fieldId) {

        foreach($userFormsData as $data) {

            if($data->field_id == $fieldId)
                return true;

        }

        return false;
        
    }

    private function checkAsset($asset, $userFormsData, $userAssetId) {
        

        $forms = $asset->forms;
        $errs = [];

        foreach($forms as $form) {

            if($form->step == 1)
                continue;

            $fields = $form->form_fields;

            foreach($fields as $field) {

                if($field->type == 'LISTVIEW') {

                    $subAssetId = explode('_', $field->options)[1];
                    if(UserSubAsset::where('asset_id',$subAssetId)->where('user_asset_id',$userAssetId)->count() == 0)
                        array_push($errs, $form->name . " : " . $field->name);

                    continue;
                }
                

                if($field->necessary && !$this->hasUserAnswerToThisField($userFormsData, $field->id))
                    array_push($errs, $form->name . " : " . $field->name);

            }
        }

        return $errs;
    }

    public function updateStatus(UserAsset $user_asset) {
        
        $userFormsData = $user_asset->user_forms_data()->get();
        $asset = $user_asset->asset;
        
        $errs = $this->checkAsset($asset, $userFormsData, $user_asset->id);

        if(count($errs) > 0) {
            return response()->json([
                'status' => -2,
                'errs' => $errs
            ]);
        }
        
        $user_asset->status = "PENDING";

        if($user_asset->ticket_id == null) {
            $newTicket = new Ticket();
            $newTicket->userId = $user_asset->user_id;
            $newTicket->adminSeen = 0;
            $newTicket->adminId = 0;
            $newTicket->seen = 1;

            $newTicket->subject = 'درخواست بررسی فرم ' . $asset->name . ' ' . $user_asset->title;
            $newTicket->parentId = null;
            $newTicket->businessId = $user_asset->id;

            $newTicket->msg = 'درخواست بررسی فرم ' . $asset->name . ' ' . $user_asset->title;
            $newTicket->save();

            $user_asset->ticket_id = $newTicket->id;
        }

        $user_asset->save();

        return response()->json([
            "status" => "0"
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\UserAsset  $userAsset
     * @return \Illuminate\Http\JsonResponse
     */
    public static function destroy(UserAsset $user_asset, Request $request) {

        try {
            DB::transaction(function () use ($user_asset, $request) {

                $pic = $user_asset->pic;

                if($pic != null) {

                    if (file_exists(__DIR__ . '/../../../../storage/app/public/' . $pic))
                        unlink(__DIR__ . '/../../../../storage/app/public/' . $pic);
                }
                $userFormsData = UserFormsData::where('user_asset_id',$user_asset->id)->where('is_sub_asset',false)->get();
            
                foreach ($userFormsData as $itr) {
                    if (strpos($itr->data, "assets/") !== false &&
                        file_exists(__DIR__ . '/../../../../storage/app/' . $itr->data)) {
                        unlink(__DIR__ . '/../../../../storage/app/' . $itr->data);
                    }

                    $itr->delete();
                }
                
                $assets = Asset::where('super_id', $user_asset->asset_id)->get();
                            
                foreach ($assets as $asset) {
                    $userSubAssets = $asset->user_sub_assets;
                    if($userSubAssets !== null){
                        foreach ($userSubAssets as $userSubAsset) UserSubAssetController::destroy($userSubAsset, $request);
                    }
                }
                
                $user_asset->delete();
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
