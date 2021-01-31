<?php

namespace App\Http\Controllers;

use App\models\news\News;
use App\models\places\Amaken;
use App\models\Cities;
use App\models\places\Place;
use App\models\Post;
use App\models\safarnameh\Safarnameh;
use App\models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemap.index')->header('Content-Type', 'application/xml');
    }

    public function places()
    {
        $pl = [];
        $lists = [];
        $count = 0;
        $kindPlaces = Place::whereIn('id', [1, 3, 4, 6, 10, 11, 12])->get();
        foreach ($kindPlaces as $kindPlace) {
            if ($kindPlace->tableName != null) {
                $places = \DB::table($kindPlace->tableName)->select(['id', 'slug', 'name'])->get();
                foreach ($places as $place) {
                    if($place->slug != null) {
                        $slug = urlencode($place->slug);
                        $place->url = url('show-place-details/' . $kindPlace->fileName . '/' . $slug);
                        $count++;
                        array_push($pl, $place);
                        array_push($lists, $place->url);
                    }
                }
            }
        }

//        return response()->view('sitemap.places', ['places' => $pl])->header('Content-Type', 'application/xml');
        return response()->view('sitemap.siteMapUrls', ['lists' => $lists])->header('Content-Type', 'application/xml');
    }

    public function lists()
    {
        $kindPlaces = [1, 3, 4, 6, 10, 11, 12];
        $state = State::all();

        $lists = [
            url('placeList/1/country'),
            url('placeList/3/country'),
            url('placeList/4/country'),
            url('placeList/6/country'),
            url('placeList/10/country'),
            url('placeList/11/country'),
            url('placeList/12/country'),
        ];

        foreach ($state as $item){
            foreach ($kindPlaces as $kindPlace){
                $slug = urlencode($item->name);
                $l = url('placeList/' . $kindPlace . '/state/' . $slug);
                array_push($lists, $l);
            }
        }

        $cities = Cities::where('isVillage', 0)->get();
        foreach ($cities as $city) {
            foreach ($kindPlaces as $kindPlace){
                $slug = urlencode($city->name);
                $l = url('placeList/' . $kindPlace . '/city/' . $slug);
                array_push($lists, $l);
            }
        }

        return response()->view('sitemap.siteMapUrls', ['lists' => $lists])->header('Content-Type', 'application/xml');
    }

    public function posts()
    {
        $today = getToday()["date"];
        $nowTime = getToday()["time"];
        $post = Safarnameh::whereRaw('(safarnameh.date < ' . $today . ' OR (safarnameh.date = ' . $today . ' AND  (safarnameh.time <= ' . $nowTime . ' OR safarnameh.time IS NULL)))')->select(['id', 'title', 'slug', 'created_at'])->get();

        $lists = array();
        foreach ($post as $item) {
            if($item->slug != null && $item->slug != '') {
                $l = url('/safarnameh/show/'.$item->id);
//                array_push($lists, [$l, $item->created_at]);
                array_push($lists, $l);
            }
        }

        return response()->view('sitemap.siteMapUrls', ['lists' => $lists])->header('Content-Type', 'application/xml');
    }

    public function news()
    {
        $news = News::youCanSee()->select(['id', 'title', 'slug', 'created_at'])->orderByDesc('created_at')->take(500)->get();

        foreach ($news as $item) {
            if($item->slug != null && $item->slug != '')
                $item->url = url("/news/show/{$item->slug}");
        }

        return response()->view('sitemap.newsSiteMapUrls', ['news' => $news])->header('Content-Type', 'application/xml');
    }

    public function city()
    {
        $state = State::all();

        $lists = array();

        foreach ($state as $item){
            $slug = urlencode($item->name);
            $l = url('cityPage/state/'.$slug);
            array_push($lists, $l);
        }

        $cities = Cities::where('isVillage', 0)->get();
        foreach ($cities as $city) {
            $slug = urlencode($city->name);
            $l = url('cityPage/city/'.$slug);
            array_push($lists, $l);
        }

        return response()->view('sitemap.siteMapUrls', ['lists' => $lists])->header('Content-Type', 'application/xml');
    }

    public function village()
    {
        $lists = [];
        $cities = Cities::where('isVillage', '!=', 0)->get();
        foreach ($cities as $city) {
            $slug = urlencode($city->name);
            $l = url('cityPage/city/'.$slug);
            array_push($lists, $l);
        }

        return response()->view('sitemap.siteMapUrls', ['lists' => $lists])->header('Content-Type', 'application/xml');
    }
}
