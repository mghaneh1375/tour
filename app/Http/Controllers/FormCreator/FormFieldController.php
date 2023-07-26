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
        }

        return view('field', ['form' => $form,
            'subAssets' => Asset::whereSuperId($form->asset_id)->get(),
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
                "CALENDAR", "FILE", "LISTVIEW", "GALLERY", "MAP", "TIME", "FLOAT", "TEXTAREA", "API"])],
            "help" => ["nullable", "max:1000"],
            "placeholder" => ["nullable", "max:1000"],
            "force_help" => ["nullable", "max:1000"],
            "err" => ["nullable", "max:1000"]
        ]);

        $field = new FormField();
        $field->form_id = $form->id;
        $field->name = $request["name"];
        $field->type = $request["type"];

        if($request->has("necessary") && $request["necessary"] == "1")
            $field->necessary = true;
        else
            $field->necessary = false;

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

        if($field->type == "LISTVIEW") {
            if($request->has("subAsset") &&
                Asset::whereId($request["subAsset"])->whereSuperId($form->asset_id)->count() > 0)
                $field->options = "sub_" . $request["subAsset"];
            else
                dd("خطا در ورودی");
        }

        elseif($field->type == "REDIRECTOR") {

            if($request->has("form") &&
                Form::whereId($request["form"])->whereAssetId($form->asset_id)->count() > 0)
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
        return Redirect::to("form/" . $form->id . '/form_field');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\FormField  $formField
     * @return \Illuminate\Http\Response
     */
    public function edit(FormField $formField)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\FormField  $formField
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormField $formField)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\FormField  $formField
     * @return \Illuminate\Http\JsonResponse
     */
    public static function destroy(FormField $formField) {

        if($formField->type == "FILE" || $formField->type == "GALLERY") {

            $data = UserFormsData::whereFieldId($formField->id)->get();

//            foreach ($data as $itr) {
//                if(file_exists(__DIR__ . '/../../../public/storage/' . ))
//            }

        }

        $formField->delete();

        return response()->json([
            "status" => "0"
        ]);
    }
}
