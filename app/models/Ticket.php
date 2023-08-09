<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Ticket'
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $adminId
 * @property integer $businessId
 * @property boolean $seen
 * @property boolean $adminSeen
 * @property boolean $close
 * @property boolean $isForBusiness
 * @property string|null $msg
 * @property string|null $file
 * @property string|null $subject
 * @property integer|null $parentId
 * @method static \Illuminate\Database\Query\Builder|\App\models\Ticket whereParentId($value)
 */

class Ticket extends Model {

    protected $guarded = [];
    protected $table = 'tickets';

    public static function whereId($value) {
        return Ticket::find($value);
    }

    public static function deleteTicket(Ticket $ticket) {

        if($ticket->parentId != null)
            return;

        $msgs = Ticket::whereParentId($ticket->id)->get();

        foreach ($msgs as $msg) {
            Ticket::deleteMsg($msg);
        }

        if($ticket->file != null && !empty($ticket->file) &&
            file_exists(__DIR__ . '/../../storage/app/public/' . $ticket->file)
        )
            unlink(__DIR__ . '/../../storage/app/public/' . $ticket->file);

        $ticket->delete();
    }

    public static function deleteMsg(Ticket $ticket) {

        if($ticket->parentId == null)
            return;

        if($ticket->file != null && !empty($ticket->file) &&
            file_exists(__DIR__ . '/../../storage/app/public/' . $ticket->file)
        )
            unlink(__DIR__ . '/../../storage/app/public/' . $ticket->file);

        $ticket->delete();
    }
}
