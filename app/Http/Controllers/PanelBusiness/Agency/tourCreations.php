<?php


namespace App\Http\Controllers\PanelBusiness\Agency;


use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;

interface tourCreations
{
    public function showStep_1($tour);
    public function storeStep_1($request, $business);

    public function showStep_2($tour);
    public function storeStep_2($request, $tour);

    public function showStep_3($tour);
    public function storeStep_3($request, $tour);

    public function showStep_4($tour);
    public function storeStep_4($request, $tour);

    public function showStep_5($tour);
    public function storeStep_5($request, $tour);

    public function deleteTour($tour);
}
