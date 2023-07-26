<?php


namespace App\Helpers;


use App\models\Activity;
use App\models\places\Place;
use App\models\State;

class DefaultDataDB{
    private static $kindPlaceWithIds = [];
    private static $kindPlace = [];

    private static $states = [];

    private static $activityWithId = [];
    private static $activityWithName = [];

    public static function setPlaceDB(){
        self::$kindPlace = Place::whereNotNull('tableName')->get();
        foreach(self::$kindPlace as $item)
            self::$kindPlaceWithIds[$item->id] = $item;

        foreach(State::all() as $item)
            self::$states[$item->id] = $item;

        foreach (Activity::all() as $item){
            self::$activityWithId[$item->id] = $item;
            self::$activityWithName[$item->name] = $item;
        }
    }


    public static function getActivityWithName($name){
        if(isset(self::$activityWithName[$name]))
            return self::$activityWithName[$name];
        else
            return null;
    }
    public static function getActivityWithId($id){
        if(isset(self::$activityWithId[$id]))
            return self::$activityWithId[$id];
        else
            return null;
    }

    public static function getStateWithId($id){
        if(isset(self::$states[$id]))
            return self::$states[$id];
        else
            return null;
    }

    public static function getPlaceDB(){
        return self::$kindPlaceWithIds;
    }

    public static function getSinglePlace($id){
        if(isset(self::$kindPlaceWithIds[$id]))
            return self::$kindPlaceWithIds[$id];
        else
            return null;
    }

    public static function getPlaceDBAll(){
        return self::$kindPlace;
    }
}
