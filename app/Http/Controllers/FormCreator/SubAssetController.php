<?php


namespace App\Http\Controllers\FormCreator;

use App\Http\Controllers\Controller;
use App\models\FormCreator\Asset;
use App\models\FormCreator\UserSubAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class SubAssetController extends Controller {

    public function index(Asset $asset) {
        return view('formCreator.asset', ['assets' => Asset::where('super_id',$asset->id)->get(), 'subAsset' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
            "mode" => ['required', Rule::in(["FULL", "HALF", "2/3", "1/3"])],
            'pic' => 'image',
            'create_pic' => 'image',
            'view_index' => 'required|integer|min:1|unique:assets,view_index'
        ]);

        $asset = new Asset();
        $asset->name = $request["name"];
        $asset->mode = $request["mode"];
        $asset->view_index = $request["view_index"];
        $asset->hidden = ($request->has("hidden")) ? true : false;

        $t = time();

        $file = $request->file('pic');
        $Image = $t . '.' . $request->file('pic')->extension();
        $destenationpath = __DIR__ . '/../../../../public/assets';
        $file->move($destenationpath, $Image);
        $asset->pic = $Image;

        $file = $request->file('create_pic');
        $Image = ($t + 200) . '.' . $request->file("create_pic")->extension();
        $destenationpath = __DIR__ . '/../../../../public/assets';
        $file->move($destenationpath, $Image);
        $asset->create_pic = $Image;
        $asset->save();

        return Redirect::to('asset');
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Asset  $asset
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, Asset $asset) {

        $request->validate([
            'name' => 'required',
            "mode" => 'required|in:FULL,HALF,2/3,1/3',
            'view_index' => 'required|integer|min:1|unique:formDB.forms,asstes|min:1'
        ],['view_index.unique' => "اولویت نمایش باید منحصر به فرد باشد"]);


        $asset->name = $request["name"];
        $asset->mode = $request["mode"];

        $asset->view_index = $request["view_index"];
        $asset->hidden = ($request->has("hidden")) ? true : false;

        if($request->has("pic") && !empty($_FILES["pic"]["name"])) {

            if(file_exists(__DIR__ . '/../../../../public/assets/' . $asset->pic))
                unlink(__DIR__ . '/../../../../public/assets/' . $asset->pic);

            $file = $request->file('pic');
            $Image = time() . '.' . $request->file('pic')->extension();
            $destenationpath = __DIR__ . '/../../../../public/assets';
            $file->move($destenationpath, $Image);
            $asset->pic = $Image;
        }

        if($request->has("create_pic") && !empty($_FILES["create_pic"]["name"])) {

            if(file_exists(__DIR__ . '/../../../../public/assets/' . $asset->create_pic))
                unlink(__DIR__ . '/../../../../public/assets/' . $asset->create_pic);

            $file = $request->file('create_pic');
            $Image = time() . '.' . $request->file("create_pic")->extension();
            $destenationpath = __DIR__ . '/../../../public/assets';
            $file->move($destenationpath, $Image);
            $asset->create_pic = $Image;
        }

        $asset->save();
        return Redirect::to('asset');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Asset  $asset
     * @return \Illuminate\Http\JsonResponse
     */
    public static function destroy(Asset $asset, Request $request) {

        DB::transaction(function () use ($asset, $request) {

            if (file_exists(__DIR__ . '/../../../../public/assets/' . $asset->create_pic))
                unlink(__DIR__ . '/../../../../public/assets/' . $asset->create_pic);

            if (file_exists(__DIR__ . '/../../../../public/assets/' . $asset->pic))
                unlink(__DIR__ . '/../../../../public/assets/' . $asset->pic);

            $forms = $asset->forms;
            foreach ($forms as $form)
                FormController::destroy($form);

            if ($asset->super_id == -1) {

                $userAssets = $asset->user_assets();
                foreach ($userAssets as $userAsset)
                    UserAssetController::destroy($userAsset, $request);

                $subAssets = Asset::where('super_id',$asset->id)->get();
                foreach ($subAssets as $subAsset)
                    AssetController::destroy($subAsset, $request);
            }
            else {
                $userSubAssets = UserSubAsset::where('asset_id',$asset->id)->get();
                foreach ($userSubAssets as $userSubAsset)
                    UserSubAssetController::destroy($userSubAsset, $request);
            }

            $asset->delete();

        });

        return response()->json([
            "status" => "0"
        ]);
    }

}
