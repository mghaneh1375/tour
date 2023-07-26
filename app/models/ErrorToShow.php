<?php

namespace App\models;

use App\Events\HandleCreatingModelQuery;
use App\Events\HandleDeletingModelQuery;
use App\Events\HandleSaveModelQuery;
use App\Events\HandleSavingModelQuery;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string location
 * @property string section
 * @property string text
 */
class ErrorToShow extends Model
{
    protected $table = 'errorToShows';
}
