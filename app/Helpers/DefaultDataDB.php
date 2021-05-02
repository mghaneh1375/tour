<?php


namespace App\Helpers;


use App\models\places\Place;

class DefaultDataDB{
    private static $kindPlaceWithIds = [];
    private static $kindPlace = [];

    public static function setPlaceDB(){
        self::$kindPlace = Place::all();
        foreach(self::$kindPlace as $item)
            self::$kindPlaceWithIds[$item->id] = $item;
    }

    public static function getPlaceDB(){
        return self::$kindPlaceWithIds;
    }

    public static function getPlaceDBAll(){
        return self::$kindPlace;
    }
}
