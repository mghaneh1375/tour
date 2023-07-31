<?php

namespace App\models\FormCreator;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

/**
 * App\FormField
 *
 * @property int $id
 * @property string|null $placeholder
 * @property string|null $force_help
 * @property string|null $help
 * @property string|null $limitation
 * @property int $form_id
 * @property int $type
 * @property boolean $necessary
 * @property boolean $presenter
 * @property boolean $half
 * @property boolean $multiple
 * @property string $name
 * @property string|null $options
 * @property string|null $err
 * @property-read \App\models\Form $form
 * @method static Builder|FormField newModelQuery()
 * @method static Builder|FormField newQuery()
 * @method static Builder|FormField query()
 * @method static Builder|FormField whereFormId($value)
 * @method static Builder|FormField wherePresenter($value)
 * @method static Builder|FormField whereId($value)
 * @mixin \Eloquent
 */
class FormField extends FormCreatorBaseModel
{


    protected $fillable = ['name', 'placeholder', 'force_help', 'limitation', 'help','rtl', 'necessary', 'type', 'form_id'];
    public $timestamps = false;
    public $table = 'form_fields';
    
    protected  $connection = 'formDB';

    public function form() {
        return $this->belongsTo(Form::class);
    }

    private function _custom_check_national_code($code) {

        if(!preg_match('/^[0-9]{10}$/',$code))
            return false;

        for($i=0;$i<10;$i++)
            if(preg_match('/^'.$i.'{10}$/',$code))
                return false;
        for($i=0,$sum=0;$i<9;$i++)
            $sum+=((10-$i)*intval(substr($code, $i,1)));
        $ret=$sum%11;
        $parity=intval(substr($code, 9,1));
        if(($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
            return true;
        return false;
    }

    public function validateData($data, $checkUnique=false) {

        if(!$checkUnique) {
            if ($this->type == "INT") {
                if (!preg_match("/^(([0-9]*_?)+)$/D", $data))
                    return false;
            } else if ($this->type == "TIME") {
                if (!preg_match("/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/D", $data))
                    return false;
            } else if ($this->type == "RADIO") {
                $options = explode("_", $this->options);
            }
        }

        if ($this->limitation != null && !empty($this->limitation)) {

            $limitations = explode('_', $this->limitation);
            foreach ($limitations as $limitation) {

                if (empty($limitation))
                    continue;

                $limitation = explode(":", $limitation);
                $key = $limitation[0];
                $val = $limitation[1];

                if($key != 3 && $checkUnique)
                    continue;

                if ($key == 1) {
                    if (strlen($data . '') != $val) {
                        return false;
                    }
                }
                else if($key == 9 && $val == 1) {
                    if(!$this->_custom_check_national_code($data))
                        return false;
                }

                else if($key == 3 && $checkUnique) {
                    $url = "http://" . $val;
                    $username = $limitation[2];
                    $pass = $limitation[3];
                    $apiRes = Http::post($url, [
                        "username" => $username,
                        "password" => $pass,
                        "data" => $data
                    ])->json();

                    if($apiRes["status"] == "-1")
                        return false;

                    return true;
                }
            }
        }

        return true;
    }

}
