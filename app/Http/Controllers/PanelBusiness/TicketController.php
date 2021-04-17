<?php

namespace App\Http\Controllers\PanelBusiness;

use App\Http\Controllers\Controller;
use App\models\Business\Business;
use App\models\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class TicketController extends Controller {

    public function ticketPage(){
        $tickets = Ticket::where('userId', \auth()->user()->id)->whereNull('parentId')->orderByDesc('updated_at')->get();
        foreach($tickets as $tic){
            $tic->hasNew = Ticket::where('userId', \auth()->user()->id)->where('parentId', $tic->id)->where('seen', 0)->count();
            $tic->closeType = $tic->close == 1 ? 'بسته شده' : 'باز';
            if($tic->businessId == 0)
                $tic->businessName = 'آزاد';
            else
                $tic->businessName = Business::find($tic->businessId)->name;

            $time = $tic->updated_at->format('H:i');
            $date = verta($tic->updated_at)->format('Y/m/d');

            $tic->time = "{$date} - {$time}";
        }
        $isAdmin = 0;
        return view('panelBusiness.pages.report.ticketPage', compact(['tickets', 'isAdmin']));
    }
    public function ticketGetUser($parentId){
        $parent = Ticket::find($parentId);
        $tickets = [];
        if($parent != null){
            if($parent->userId === \auth()->user()->id){
                Ticket::where('parentId', $parent->id)->update(['seen' => 1]);

                $subs = Ticket::where('parentId', $parent->id)->orWhere('id', $parent->id)->get();
                foreach($subs as $sub){
                    $time = $sub->created_at->format('H:i');
                    $date = verta($sub->created_at)->format('Y/m/d');

                    $sub->time = "{$date} - {$time}";

                    $sub->hasFile = 0;
                    if($sub->file != null){
                        $sub->hasFile = 1;
                        $sub->fileUrl = "/storage/{$sub->file}";
                    }

                    $sub->whoSend = $sub->adminId == 0 ? 'user' : 'admin';

                    if($sub->subject != 'closed') {
                        array_push($tickets, [
                            'id' => $sub->id,
                            'time' => $sub->time,
                            'hasFile' => $sub->hasFile,
                            'fileUrl' => $sub->fileUrl,
                            'fileName' => $sub->fileName,
                            'msg' => $sub->msg,
                            'whoSend' => $sub->whoSend,
                            'close' => $parent->close,
                            'canDelete' => $sub->adminSeen == 0 ? 1 : 0,
                        ]);
                    }

                }
                return response()->json(['status' => 'ok', 'result' => $tickets, 'isClose' => $parent->close]);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }
    public function storeTicketUser(Request $request){
        $parent = null;
        if(isset($request->ticketId) && $request->ticketId != 0) {
            $parent = Ticket::find($request->ticketId);
            if($parent->close == 1)
                return response()->json(['status' => 'closed']);
            else if($parent->userId != \auth()->user()->id)
                return response()->json(['status' => 'errorAuth']);
        }

        $newTicket = new Ticket();
        $newTicket->userId = \auth()->user()->id;
        $newTicket->adminSeen = 0;
        $newTicket->adminId = 0;
        $newTicket->seen = 1;

        if($parent == null){
            $newTicket->subject = $request->subject ?? null;
            $newTicket->parentId = null;
            $newTicket->businessId = $request->businessId === 'free' ? 0 : $request->businessId;
        }
        else{
            $newTicket->parentId = $parent->id;
            $newTicket->businessId = $parent->businessId;

            if($request->has("file")) {
                $newTicket->fileName = $request->file('file')->getClientOriginalName();
                $path = $request->file->store('public/tickets');
                $path = str_replace('public/', '', $path);
                $newTicket->file = $path;
            }
        }
        $newTicket->msg = $request->description ?? null;
        $newTicket->save();

        if($parent != null) {
            $parent->updated_at = Carbon::now();
            $parent->save();
        }

        return response()->json(['status' => 'ok', 'result' => $newTicket->id]);
    }
    public function deleteTicketUser(Request $request){
        if(!isset($request->id)) return response()->json(['status' => 'error0']);

        $ticket = Ticket::find($request->id);
        if($ticket == null) return response()->json(['status' => 'error1']);
        if($ticket->adminId != 0) return response()->json(['status' => 'error2']);
        if($ticket->userId != \auth()->user()->id) return response()->json(['status' => 'error3']);
        if($ticket->adminSeen != 0) return response()->json(['status' => 'error4']);
        if($ticket->subject != null) return response()->json(['status' => 'error5']);

        $parent = Ticket::find($ticket->parentId);
        if($parent == null) return response()->json(['status' => 'error6']);
        if($parent->close === 1) return response()->json(['status' => 'error7']);

        if($ticket->file != null)
            Storage::delete("public/{$ticket->file}");

        $ticket->delete();
        return response()->json(['status' => 'ok']);
    }

    public function adminTicketPage(){
        $tickets = Ticket::join('users', 'users.id', 'tickets.userId')
                            ->whereNull('tickets.parentId')
                            ->select(['tickets.*', 'users.first_name', 'users.last_name'])
                            ->orderByDesc('tickets.updated_at')
                            ->get();
        foreach($tickets as $tic){
            $tic->hasNew = Ticket::where('parentId', $tic->id)->where('adminSeen', 0)->count();
            if($tic->businessId == 0)
                $tic->businessName = 'آزاد';
            else
                $tic->businessName = Business::find($tic->businessId)->name;

            $time = $tic->updated_at->format('H:i');
            $date = verta($tic->updated_at)->format('Y/m/d');
            $tic->time = "{$date} - {$time}";

            $tic->user = $tic->first_name . ' ' . $tic->last_name;
        }
        $isAdmin = 1;

        return view('panelBusiness.pages.report.ticketPage', compact(['tickets', 'isAdmin']));
    }
    public function ticketGetAdmin($parentId){
        $parent = Ticket::find($parentId);
        $tickets = [];
        if($parent != null){
            if($parent->adminSeen === 0)
                $parent->update(['adminSeen' => 1]);

            Ticket::where('parentId', $parent->id)->update(['adminSeen' => 1]);
            $subs = Ticket::where('parentId', $parent->id)->orWhere('id', $parent->id)->get();
            foreach($subs as $sub){
                $time = $sub->created_at->format('H:i');
                $date = verta($sub->created_at)->format('Y/m/d');

                $sub->time = "{$date} - {$time}";

                $sub->hasFile = 0;
                if($sub->file != null){
                    $sub->hasFile = 1;
                    $sub->fileUrl = "/storage/{$sub->file}";
                }

                if($sub->adminId === 0) {
                    $sub->adminName = '';
                    $sub->whoSend = 'user';
                }
                else{
                    $adU = User::find($sub->adminId);
                    $sub->adminName = $adU->first_name.' '.$adU->last_name;
                    $sub->whoSend = 'admin';
                }

                if($sub->subject != 'closed') {
                    array_push($tickets, [
                        'id' => $sub->id,
                        'time' => $sub->time,
                        'adminName' => $sub->adminName,
                        'hasFile' => $sub->hasFile,
                        'fileUrl' => $sub->fileUrl,
                        'fileName' => $sub->fileName,
                        'msg' => $sub->msg,
                        'whoSend' => $sub->whoSend,
                        'close' => $parent->close,
                        'canDelete' => 0,
                    ]);
                }

            }
            return response()->json(['status' => 'ok', 'result' => $tickets, 'isClose' => $parent->close]);
        }
        else
            return response()->json(['status' => 'error1']);
    }
    public function storeTicketAdmin(Request $request){
        if(!isset($request->ticketId))
            return response()->json(['status' => 'error1']);

        if(!isset($request->description) && !$request->has("file"))
            return response()->json(['status' => 'error2']);

        $parent = Ticket::find($request->ticketId);
        if($parent == null)
            return response()->json(['status' => 'error3']);

        if($parent->close == 1)
            return response()->json(['status' => 'closed']);


        $newTicket = new Ticket();
        $newTicket->userId = $parent->userId;
        $newTicket->adminId = \auth()->user()->id;
        $newTicket->adminSeen = 1;
        $newTicket->seen = 0;
        $newTicket->parentId = $parent->id;
        $newTicket->businessId = $parent->businessId;
        $newTicket->msg = $request->description ?? null;
        if($request->has("file")) {
            $newTicket->fileName = $request->file('file')->getClientOriginalName();
            $path = $request->file->store('public/tickets');
            $path = str_replace('public/', '', $path);
            $newTicket->file = $path;
        }
        $newTicket->save();

        $parent->updated_at = Carbon::now();
        $parent->save();

        return response()->json(['status' => 'ok']);

    }
    public function closeTicket(Request $request){
        $ticket = Ticket::find($request->id);
        if($ticket == null)
            return response()->json(['status' => 'error1']);

        $newTicket = new Ticket();
        $newTicket->subject = 'closed';
        $newTicket->adminId = \auth()->user()->id;
        $newTicket->userId = $ticket->userId;
        $newTicket->businessId = $ticket->businessId;
        $newTicket->parentId = $ticket->id;
        $newTicket->seen = 1;
        $newTicket->adminSeen = 1;
        $newTicket->save();

        Ticket::where('parentId', $ticket->id)->orWhere('id', $ticket->id)->update(['close' => 1]);
        return response()->json(['status' => 'ok']);
    }
}
