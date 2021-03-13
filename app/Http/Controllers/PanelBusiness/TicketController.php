<?php

namespace App\Http\Controllers\PanelBusiness;

use App\Http\Controllers\Controller;
use App\models\Business\Business;
use App\models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TicketController extends Controller {

    public function msgs(Business $business) {
        return view('panelBusiness.pages.report.msgs', ['id' => $business->id]);
    }

    public function specificMsgs(Ticket $ticket) {
        return view('panelBusiness.pages.report.specificMsgs', ['id' => $ticket->id,
            'ticket' => $ticket]);
    }

    public function generalMsgs(Business $business) {

        $msgs = Ticket::where('from_', '=', $business->assignUserId)
            ->orWhere('to_', '=', $business->assignUserId)
            ->whereNull('parentId')
            ->select('id', 'subject', 'created_at', 'updated_at', 'close')
            ->get();

        foreach ($msgs as $msg) {

            $time = $msg->created_at->format('H:i:s');
            $date = verta($msg->created_at)->format('Y-m-d');
            $msg->create = $date . ' - ' . $time;

            $time = $msg->updated_at->format('H:i:s');
            $date = verta($msg->updated_at)->format('Y-m-d');
            $msg->update = $date . ' - ' . $time;
        }

        return response()->json([
            "msgs" => $msgs
        ]);
    }

    public function ticketMsgs(Ticket $ticket) {

        $time = $ticket->created_at->format('H:i:s');
        $date = verta($ticket->created_at)->format('Y-m-d');
        $ticket->create = $date . ' - ' . $time;

        $others = Ticket::where('parentId', $ticket->id)->get();
        foreach ($others as $other) {
            $time = $other->created_at->format('H:i:s');
            $date = verta($other->created_at)->format('Y-m-d');
            $other->create = $date . ' - ' . $time;
        }

        return response()->json([
            'ticket' => $ticket,
            "others" => $others
        ]);
    }

    public function addMsg(Ticket $ticket, Request $request) {

        $newTicket = new Ticket();
        $newTicket->parentId = $ticket->id;

        if(Auth::user()->level == 0) {
            if($ticket->from_ == null)
                $newTicket->from_ = $ticket->to_;
            else
                $newTicket->from_ = $ticket->from_;
        }
        else {
            if($ticket->from_ == null)
                $newTicket->to_ = $ticket->to_;
            else
                $newTicket->to_ = $ticket->from_;
        }

        if($request->has("msg") && !empty($request["msg"]))
            $newTicket->msg = $request["msg"];

        if($request->has("file")) {
            $path = $request->file->store('public');
            $path = str_replace('public/', '', $path);
            $newTicket->file = $path;
        }

        $newTicket->save();
        return Redirect::route('ticket.specificMsgs', ['ticket' => $ticket->id]);
    }

    public function addTicket(Business $business, Request $request) {

        $request->validate([
            "title" => "required"
        ]);

        $ticket = new Ticket();
        $ticket->subject = $request["title"];

        if(Auth::user()->level == 0)
            $ticket->from_ = $business->assignUserId;
        else
            $ticket->to_ = $business->assignUserId;

        if($request->has("msg") && !empty($request["msg"]))
            $ticket->msg = $request["msg"];

        if($request->has("file")) {
            $path = $request->file->store('public');
            $path = str_replace('public/', '', $path);
            $ticket->file = $path;
        }

        $ticket->save();
        return Redirect::route('ticket.msgs', ['business' => $business->id]);
    }

    public function close(Ticket $ticket) {

        $ticket->close = true;
        $ticket->save();

        return response()->json([
            "status" => "0"
        ]);
    }

    public function open(Ticket $ticket) {

        $ticket->close = false;
        $ticket->save();

        return response()->json([
            "status" => "0"
        ]);
    }

    public function delete(Ticket $ticket) {

        $parentId = $ticket->parentId;
        if($parentId == null)
            Ticket::deleteTicket($ticket);
        else
            Ticket::deleteMsg($ticket);

        return response()->json([
            "status" => "0",
            "redirect" => ($parentId == null) ? route('home') : ""
        ]);
    }

}
