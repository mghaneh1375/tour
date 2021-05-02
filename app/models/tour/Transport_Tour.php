<?php

namespace App\models\tour;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int id
 * @property int tourId
 * @property int sTransportId
 * @property int eTransportId
 * @property string sTime
 * @property string eTime
 * @property string sDescription
 * @property string eDescription
 * @property string sAddress
 * @property string eAddress
 * @property string sLatLng
 * @property string eLatLng
 */
class Transport_Tour extends Model
{
    protected $guarded = [];
    protected $table = 'transportTours';
    public $timestamps = false;
}
