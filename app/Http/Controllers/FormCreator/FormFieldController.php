<?php

namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\models\FormCreator\Asset;
use App\models\FormCreator\Form;
use App\models\FormCreator\FormField;
use App\models\FormCreator\UserFormsData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class FormFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Form $form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Form $form) {

        $fields = $form->form_fields;
        foreach ($fields as $field) {

            if($field->type == "CHECKBOX" || $field->type == "RADIO")
                $field->type = $field->type . "<br/>" . "گزینه ها: " . "<br/>" . $field->options;
            else if($field->type == "API")
                $field->type = $field->type . "<br/>" . "مشخصات سرویس دهنده: " . "<br/>" . $field->options;
            else if($field->type == "STRING")
                $field->type = 'رشته حروف';
            else if($field->type == "FLOAT")
                $field->type = 'عدد اعشاری';
            else if($field->type == "INT")
                $field->type = 'عدد صحیح';
            else if($field->type == "MAP")
                $field->type = 'مختصات جغرافیایی';
            else if($field->type == "CALENDAR")
                $field->type = 'تاریخ';
            else if($field->type == "TIME")
                $field->type = 'ساعت';
            else if($field->type == "CKEDITOR")
                $field->type = 'CKEDITOR';
            else if($field->type == "TEXTAREA")
                $field->type = 'متن بلند';
            else if($field->type == "GALLERY")
                $field->type = 'گالری';
            else if($field->type == "LISTVIEW")
                $field->type = 'لیستی از sub assets'; 
            else if($field->type == "RADIO")
                $field->type = 'انتخاب یک گزینه از میان گزینه های موجود';
            else if($field->type == "CHECKBOX")
                $field->type = 'انتخاب چند گزینه از میان گزینه های موجود';
            else if($field->type == "FILE")
                $field->type = 'تک عکس';
            else if($field->type == "REDIRECTOR")
                $field->type = 'هدایت گر به فرم دیگر';
                 


            $limitations = $field->limitation;
            if($limitations != null && !empty($limitations)) {
                $splited = explode("_", $limitations);
                $str = "";
                foreach ($splited as $itr) {

                    if (empty($itr))
                        continue;

                    $itr = explode(":", $itr);
                    $key = $itr[0];
                    $val = $itr[1];

                    if ($key == 1)
                        $str .= "محدودیت تعداد کاراکتر: " . $val . '<br/>';

                    else if($key == 9 && $val == 1)
                        $str .= "صحت سنجی کد ملی " . '<br/>';

                }
                $field->limitation = $str;
            }
            else
                $field->limitation = "محدودیتی موجود نیست";
                
            $field->editUrl = route('form_field.update', ['form_field' => $field->id]);
        }

        return view('formCreator.field', ['form' => $form,
            'subAssets' => Asset::where('super_id',$form->asset_id)->get(),
            'forms' => $form->asset->forms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Form $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Form $form) {

        $request->validate([
            "name" => "required",
            "type" => ["required", Rule::in(["STRING", "INT", "CHECKBOX", "RADIO", "REDIRECTOR",
                "CALENDAR", "FILE", "LISTVIEW", "GALLERY", "MAP", "TIME", "FLOAT", "TEXTAREA", "API", "CKEDITOR"])],
            "help" => ["nullable", "max:1000"],
            "key_" => "nullable",
            "placeholder" => ["nullable", "max:1000"],
            "force_help" => ["nullable", "max:1000"],
            "err" => ["nullable", "max:1000"],
            'presenter' => 'nullable|boolean',
            'rtl' => 'nullable|boolean',
            'half' => 'nullable|boolean',
        ]);

        $field = new FormField();
        $field->form_id = $form->id;
        $field->name = $request["name"];
        $field->type = $request["type"];
        

        if($request->has("necessary") && $request["necessary"] == "1")
            $field->necessary = true;
        else
            $field->necessary = false;
        if($request->has("rtl") && $request["rtl"] == "1")
            $field->rtl = true;
        else
            $field->rtl = false;
        if($request->has("half") && $request["half"] == "1")
            $field->half = true;
        else
            $field->half = false;

        if($request->has("multiple") && $request["multiple"] == "1")
            $field->multiple = true;
        else
            $field->multiple = false;

        $field->help = $request["help"];
        $field->err = $request["err"];
        $field->force_help = $request["force_help"];
        $field->placeholder = $request["placeholder"];
        $field->key_ = $request["key_"];

        if($field->type == "LISTVIEW") {
            if($request->has("subAsset") &&
                Asset::whereId($request["subAsset"])->where('super_id',$form->asset_id)->count() > 0)
                $field->options = "sub_" . $request["subAsset"];
            else
                dd("خطا در ورودی");
        }

        elseif($field->type == "REDIRECTOR") {

            if($request->has("form") &&
                Form::whereId($request["form"])->where('asset_id',$form->asset_id)->count() > 0)
                $field->options = "form_" . $request["form"];
            else
                dd("خطا در ورودی");
        }

        else if($field->type == "CHECKBOX" || $field->type == "RADIO" ||
            $field->type == "API") {
            if($request->has("options") && !empty($request["options"]))
                $field->options = $request["options"];
            else
                dd("خطا در ورودی");
        }

        if($request->has(["limitations"])) {
            $str = "";
            $first = true;

            foreach ($request["limitations"] as $limit) {

                if($first)
                    $first = false;
                else
                    $str .= "_";

                if($limit == 9)
                    $str .= '9:1';
                else if($limit == 1 && $request->has("charCount"))
                    $str .= "1:" . $request["charCount"];
            }
            $field->limitation = $str;
        }
        else
            $field->limitation = null;

        $field->save();
        return Redirect::route('form.form_field.index', ['form' => $form->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\FormField  $formField
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, FormField $form_field){
         
        
        $request->validate([
            "name" => "required",
            "type" => ["required", Rule::in(["STRING", "INT", "CHECKBOX", "RADIO", "REDIRECTOR",
                "CALENDAR", "FILE", "LISTVIEW", "GALLERY", "MAP", "TIME", "FLOAT", "TEXTAREA", "API", "CKEDITOR"])],
            "help" => ["nullable", "max:1000"],
            "key_" => "nullable",
            "placeholder" => ["nullable", "max:1000"],
            "force_help" => ["nullable", "max:1000"],
            "err" => ["nullable", "max:1000"],
            "limitations" => 'nullable|array',
            'presenter' => 'nullable|boolean',
            'rtl' => 'nullable|boolean',
            'half' => 'nullable|boolean',
        ]);
        
        $form_field->name = $request["name"];
        $form_field->type = $request["type"];
        

        if($request->has("necessary") && $request["necessary"] == "1")
            $form_field->necessary = true;
        else
            $form_field->necessary = false;

        if($request->has("presenter") && $request["presenter"] == "1")
            $form_field->presenter = true;
        else
            $form_field->presenter = false;

        if($request->has("half") && $request["half"] == "1")
            $form_field->half = true;
         else
            $form_field->half = false;

        if($request->has("rtl") && $request["rtl"] == "1")
            $form_field->rtl = true;
        else
            $form_field->rtl = false;

        if($request->has("multiple") && $request["multiple"] == "1")
            $form_field->multiple = true;
        else
            $form_field->multiple = false;

        $form_field->help = $request["help"];
        $form_field->err = $request["err"];
        $form_field->force_help = $request["force_help"];
        $form_field->placeholder = $request["placeholder"];
        $form_field->key_ = $request["key_"];

        if($form_field->type == "LISTVIEW") {
            if($request->has("subAsset") &&
                Asset::whereId($request["subAsset"])->where('super_id',$form_field-> form->asset_id)->count() > 0)
                $form_field->options = "sub_" . $request["subAsset"];
            else
                dd("خطا در ورودی");
        }

        elseif($form_field->type == "REDIRECTOR") {

            if($request->has("form") &&
                Form::whereId($request["form"])->where('asset_id',$form_field->form->asset_id)->count() > 0)
                $form_field->options = "form_" . $request["form"];
            else
                dd("خطا در ورودی");
        }

        else if($form_field->type == "CHECKBOX" || $form_field->type == "RADIO" ||
            $form_field->type == "API") {
            if($request->has("options") && !empty($request["options"]))
                $form_field->options = $request["options"];
            else
                return response()->json([
                    'status' => 'nok',
                    'msg' => 'لطفا option ها را وارد نمایید'
                ]);
        }

        if($request->has(["limitations"])) {
            $str = "";
            $first = true;

            foreach ($request["limitations"] as $limit) {

                if($first)
                    $first = false;
                else
                    $str .= "_";

                if($limit == 9)
                    $str .= '9:1';
                else if($limit == 1 && $request->has("charCount"))
                    $str .= "1:" . $request["charCount"];
            }
            $form_field->limitation = $str;
        }
        else
            $form_field->limitation = null;

        $form_field->save();

        return response()->json([
            'status' => 'ok'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\FormField  $formField
     * @return \Illuminate\Http\JsonResponse
     */
    public static function destroy(FormField $form_field) {



        if($form_field->type == "FILE" || $form_field->type == "GALLERY") {

            $data = UserFormsData::where('field_id',$form_field->id)->get();

        //    foreach ($data as $itr) {
        //        if(file_exists(__DIR__ . '/../../../public/storage/' . ))
        //    }

        }


        $form_field->delete();

       return response()->json([
            'status' => 'ok'
        ]);;
    }
}
