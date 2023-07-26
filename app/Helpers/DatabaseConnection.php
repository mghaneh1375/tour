<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DatabaseConnection{
    public static function setConnection($params){
        config(['database.connections.onthefly' => [
            'driver' => $params->driver,
            'host' => $params->host,
            'username' => $params->username,
            'password' => $params->password
        ]]);

        return DB::connection('onthefly');
    }
}
