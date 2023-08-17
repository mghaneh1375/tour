<?php

use App\Http\Controllers\FormCreator\AssetController;
use App\Http\Controllers\FormCreator\CKEditor;
use App\Http\Controllers\FormCreator\FormController;
use App\Http\Controllers\FormCreator\FormFieldController;
use App\Http\Controllers\FormCreator\UserAssetController;
use App\Http\Controllers\FormCreator\UserFormController;
use App\Http\Controllers\FormCreator\UserSubAssetController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "ckeditor"], function () {

    Route::post("/{userFormsData}", [CKEditor::class, 'storePic'])->name('ckeditorStorePic');

    Route::get('/', [CKEditor::class, 'showEmpty']);

    Route::get('/{userFormsData}', [CKEditor::class, 'show']);

});

Route::apiResource('state.city', CityController::class)->shallow()->only(["index"]);
Route::apiResource('state', StateController::class)->only(["index"]);

Route::get('/', [AssetController::class, 'indexAPI'])->name('formCreator.root');

Route::get('asset', [AssetController::class, 'indexAPI']);
Route::get('asset/{asset}/form', [FormController::class, 'indexAPI']);
Route::get('form/{form}', [FormController::class, 'showAPI']);
Route::get("form/{form}/{userAssetId}", [FormController::class, "showAPI"]);

// Route::apiResource('form_field', FormFieldController::class);
Route::apiResource('user_forms_data', UserFormController::class)->except("store");

// ->middleware('can:update,user_asset')
Route::post("user_forms_data/{user_asset}", [UserFormController::class, 'store']);

Route::post("user_sub_forms_data/{user_sub_asset}", [UserFormController::class, 'storeSub']);

Route::get('asset/user_assets', [UserAssetController::class, 'all']);

Route::group(['prefix' => 'asset/{asset}'], function() {

    Route::post('/user_asset', [UserAssetController::class, 'store'])->name('asset.user_asset.store');

});

// Route::apiResource('asset.user_asset', UserAssetController::class)->shallow();

Route::get("get_sub_asset/{form}", [UserSubAssetController::class, "sub_asset"]);

Route::group(["prefix" => "user_asset/{user_asset}"], function () {

    Route::delete("/", [UserAssetController::class, "destroy"]);

    Route::put('/', [UserAssetController::class, 'update'])->name('user_asset.update');
    
    Route::put("updateStatus", [UserAssetController::class, "updateStatus"]);

    Route::post("set_asset_pic/{form_field}", [UserFormController::class, 'set_asset_pic']);

    Route::post("set_pic/{form_field}", [UserFormController::class, 'set_pic']);

    Route::delete("delete_pic_from_gallery/{form_field}", [UserFormController::class, 'delete_pic_from_gallery']);

    Route::post("add_pic_to_gallery/{form_field}", [UserFormController::class, 'add_pic_to_gallery']);

    Route::post("add_video_to_gallery/{form_field}", [UserFormController::class, 'add_video_to_gallery']);

    Route::post("add_pic_to_gallery_sub/{form_field}/{sub_asset}/{user_sub_asset_id}", [UserFormController::class, 'add_pic_to_gallery_sub']);

    Route::post("add_video_to_gallery_sub/{form_field}/{sub_asset}/{user_sub_asset_id}", [UserFormController::class, 'add_video_to_gallery_sub']);

    Route::post("edit_pic_gallery/{form_field}/{curr_file}", [UserFormController::class, 'edit_pic_gallery']);
});



Route::group(['prefix' => "user_sub_asset/{user_sub_asset}"], function () {

    Route::delete('/', [UserSubAssetController::class, 'destroy']);

    Route::post("edit_pic_gallery_sub/{form_field}/{curr_file}", [UserSubAssetController::class, 'edit_pic_gallery_sub']);

    Route::delete("delete_pic_from_gallery_sub/{form_field}", [UserSubAssetController::class, 'delete_pic_from_gallery_sub']);

});

?>