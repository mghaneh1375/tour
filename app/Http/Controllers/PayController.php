<?php

namespace App\Http\Controllers;


use App\models\SoldTicket;
use App\models\SoldTicketItems;

class PayController extends Controller {

    private function sendBookRequest($soldTicket) {

        $ch = curl_init();

        $arr = [
            'invoice_token' => $soldTicket->invoiceToken,
        ];

        curl_setopt($ch, CURLOPT_URL, getenv("java_url") . "/book");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        curl_close ($ch);

        if(!$server_output || $server_output == null || \GuzzleHttp\json_decode($server_output) == null)
            return "nok";

        $tmp = \GuzzleHttp\json_decode($server_output);


        foreach ($tmp as $key => $value) {

            if ($key == "book_ticket") {
                foreach ($value as $key2 => $value2) {

                    if ($key2 == "booking_ref") {
                        $soldTicket->bookingRef = $value2;
                        $soldTicket->save();
                    }
                }
            } else if($key == "passengers") {

                $soldTicketItems = null;

                foreach ($value as $key2 => $value2) {

                    if ($key2 == "passenger_info") {
                        foreach ($value2 as $key3 => $value3) {
                            if ($key3 == "IDNumber") {
                                $soldTicketItems = SoldTicketItems::whereSoldTicketId($soldTicket->id)
                                    ->whereIDNumber($value3)->first();
                            }
                        }
                    } else if ($key2 == "code_ref" && $soldTicketItems != null) {
                        $soldTicketItems->codeRef = $value2;
                        $soldTicketItems->save();
                    }
                }
            }
        }

        return "ok";
    }

    public function doPayment($forWhat, $additionalId) {

        if($forWhat == "innerTicket") {

            $soldTicket = SoldTicket::whereId($additionalId);
            if($soldTicket != null) {

                $soldTicket->status = 2;
                $soldTicket->save();

                $result = $this->sendBookRequest($soldTicket);
                if($result == "ok") {
                    $soldTicket->status = 3;
                    $soldTicket->save();
                    dd("done");
                }

                else {
                    dd("err");
                }
            }

        }

    }

}
