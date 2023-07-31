<?php

namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
    
use App\models\FormCreator\Asset;
use App\models\FormCreator\Form;
use App\models\FormCreator\FormField;
use App\models\FormCreator\Image;
use App\models\FormCreator\SubAsset;
use App\models\FormCreator\UserAsset;
use App\models\FormCreator\UserFormsData;
use App\models\FormCreator\UserSubAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class FormController extends Controller
{

//    public function __construct() {
//        $this->authorizeResource(Form::class);
//    }

    /**
     * Display a listing of the resource.
     *
     * @param Asset $asset
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexAPI(Asset $asset) {

        return response()->json([
            "status" => 0,
            "forms" => $asset->forms()->orderBy('step', 'asc')->get()
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @param Asset $asset
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Asset $asset) {
        return view('formCreator.form', ['asset' => $asset]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Asset $asset
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Asset $asset) {

        $request->validate([
            "name" => "required",
            'step' => 'required|integer|unique:formDB.forms,step|min:1',
            'description' => ['nullable', 'max:1000'],
            'notice' => ['nullable', 'max:1000'],
        ],['step.unique' => "گام باید منحصر به فرد باشد"]);

        // if(Form::where('asset_id',$asset->id)->where('step',$request["step"])->count() > 0)
        //     return redirect::route('asset/' . $asset->id . '/form.index')->withErrors([
        //         'message' => "اولویت نمایش باید منحصر به فرد باشد"
        //     ]);

        $form = new Form();
        $form->asset_id = $asset->id;
        $form->name = $request["name"];
        $form->description = $request["description"];
        $form->notice = $request["notice"];
        $form->step = $request["step"];

        $form->save();

        return Redirect::to('asset/' . $asset->id . '/form');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\models\Form $form
     * @param int $userAssetId
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAPI(Form $form, $userAssetId = -1) {

        $isSubAsset = ($form->asset->super_id != -1);
        $userAsset = null;
        $userSubAsset = null;

        if($userAssetId != -1) {
            if ($isSubAsset) {
                $userSubAsset = UserSubAsset::where('id',$userAssetId)->first();
                if ($userSubAsset == null)
                    return response()->json([
                        "status" => -1
                    ]);
            }
            else {
                $userAsset = UserAsset::where('id',$userAssetId)->first();
                if ($userAsset == null)
                    return response()->json([
                        "status" => -1
                    ]);
            }
        }

        $userId = Auth::user()->id;

        if($userAssetId != -1) {

            if(!$isSubAsset && $form->step == 1) {

                $fields = $form->form_fields()->select(['form_fields.id as field_id', 'name', 'type', 'necessary', 'placeholder', 'half', 'rtl', 'help', 'force_help', 'multiple', 'options'])->get();

                foreach ($fields as $field) {
                    if($field->type == "FILE")
                        $field->data = $userAsset->pic;
                    else
                        $field->data = $userAsset->title;
                }
            }
            else {
                $fields = $form->form_fields()->leftJoin("user_forms_data", function ($join) use ($userId, $isSubAsset, $userAssetId) {
                    $join->on("form_fields.id", "=", "field_id")->where('user_id', $userId)->where('is_sub_asset', $isSubAsset)->where('user_asset_id', $userAssetId);
                })->select(['form_fields.id as field_id', 'user_forms_data.id as user_form_data_id', 'multiple', 'name', 'type', 'necessary', 'placeholder', 'half', 'rtl', 'data', 'help', 'force_help', 'options'])->get();

                if($form->name == "اطلاعات مالک") {
                    if($fields[0]->data == null || empty($fields[0]->data)) {
                        foreach ($fields as $field) {
                            $data = UserFormsData::where('user_id',$userId)->where('field_id',$field->field_id)->select('data')->first();
                            if($data != null && !empty($data))
                                $field->data = $data->data;
                            else
                                break;
                        }
                    }
                }
            }
        }
        else {
            $fields = $form->form_fields()->select(['form_fields.id as field_id', 'name', 'type', 'necessary', 'placeholder', 'half', 'rtl', 'help', 'force_help', 'multiple', 'options'])->get();
        }

        foreach($fields as $field) {
            $field->constraint = null;
            $field->constraintVal = null;
        }

        $update = false;
        
        foreach ($fields as $field) {

            if($userAssetId == -1)
                $field->data = null;

            // if($field->data != null) {
            //     $update = true;
            //     break;
            // }

            if($field->options != null) {
                $field->options = explode('_', $field->options);
                
                if(count($field->options) > 0 &&
                    ($field->options[0] == "form") || ($field->options[0] == "sub")
                ) {
//                    if($field->options[0] == "sub") {
//                        $x = explode('?', $field->options[1]);
//                        $field->options = [(int)$x[0], (int)$x[1]];
//                    }
//                    else
                        $field->options = [(int)$field->options[1]];
                }
            }

            $field->type = strtolower($field->type);

            if($field->type == "gallery" && $field->data != null && $field->data != '') {

                $splited = explode('_', $field->data);
                $data = "";
                $first = true;

                foreach ($splited as $str) {

                    $image = Image::whereId($str)->first();

                    if($image == null)
                        continue;

                    if($first) {
                        $first = false;
                        $data .= URL::asset("storage/" . $image->path);
                    }
                    else
                        $data .= '_' . URL::asset("storage/" . $image->path);
                }

                $field->data = $data;
            }

            else if($field->type == "listview") {

                $field->formId = Form::where('asset_id',$field->options[0])->where('step', 1)->first()->id;

                if($isSubAsset) {
                    if($userSubAsset == null)
                        $subAssets = [];
                    else
                        $subAssets = UserSubAsset::where('user_id',$userId)->where('asset_id',$field->options[0])->where('user_asset_id',$userSubAsset->id)->select("id")->get();
                }
                else
                    $subAssets = UserSubAsset::where('user_id',$userId)->where('asset_id',$field->options[0])->where('user_asset_id',$userAsset->id)->select("id")->get();

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
                                $ff->val = URL::asset("storage/" . str_replace('public/', '', $ff->val));
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

                $field->items = $subAssets;
            }

            else if($field->type == "file" && $field->data != null) {
                $field->data = URL::asset("storage/" . $field->data);
            }

            else if($userAssetId != -1 &&
                $field->type == "ckeditor" && $field->user_form_data_id == null) {
                $userFormData = new UserFormsData();
                $userFormData->user_id = Auth::user()->id;
                $userFormData->data = "";
                $userFormData->field_id =  $field->field_id;
                if($isSubAsset) {
                    $userFormData->user_asset_id = $userSubAsset->id;
                    $userFormData->is_sub_asset = true;
                }
                else
                    $userFormData->user_asset_id = $userAsset->id;

                $userFormData->save();
                $field->user_form_data_id = $userFormData->id;
            }
        }

        return response()->json([
            "status" => 0,
            "fields" => $fields,
            "form" => $form,
            "update" => ($update) ? 1 : 0
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param \App\models\Form $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, Form $form) {

        $request->validate([
            "name" => "required",
            'step' => 'required|integer|max:10|unique:formDB.forms,step|min:1',
            'description' => ['nullable', 'max:1000'],
            'notice' => ['nullable', 'max:1000'],
        ],['step.unique' => "گام باید منحصر به فرد باشد"]);

        $form->name = $request["name"];
        $form->description = $request["description"];
        $form->notice = $request["notice"];

        if($form->step != $request["step"] && Form::where('step',$request["step"])->count() > 0)
            dd("فرمی با این گام وجود دارد.");

        $form->step = $request["step"];
        $form->save();

        return Redirect::to("asset/" . $form->asset_id . "/form");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Form  $form
     * @return \Illuminate\Http\JsonResponse
     */
    public static function destroy(Form $form) {

        $fields = $form->form_fields;
        foreach ($fields as $field)
            FormFieldController::destroy($field);

        $form->delete();
        return response()->json([
            "status" => "0"
        ]);
    }
}
