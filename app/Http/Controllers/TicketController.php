<?php

namespace App\Http\Controllers;


use App\Jobs\SendJavaRequest;
use App\models\AirLine;
use App\models\ConfigModel;
use App\models\CountryCode;
use App\models\InnerFlightTicket;
use App\models\Notify;
use App\models\Passenger;
use App\models\SoldTicket;
use App\models\SoldTicketItems;
use App\models\TicketNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redirect;

class TicketController extends Controller {

    private function sendLockRequest($passengers, $phoneNum, $ticketId) {

        $ch = curl_init();

        $arr = [
            'phoneNum' => $phoneNum,
            'ticketId' => $ticketId,
            'passengers' => $passengers
        ];

        curl_setopt($ch, CURLOPT_URL, getenv("java_url") . "/lock");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        curl_close ($ch);

        if(!$server_output || $server_output == null || $server_output == "Bad format\r\n" || \GuzzleHttp\json_decode($server_output) == null)
            return "nok";

        $tmp = \GuzzleHttp\json_decode($server_output);
        $result = "nok";
        $soldTicket = new SoldTicket();

        foreach ($tmp as $key => $value) {
            if($key == "invoice_token") {
                $soldTicket->invoiceToken = $value;
                try {
                    $soldTicket->save();
                    $result = $soldTicket->id;
                }
                catch (\Exception $x) {
                    return $result;
                }
            }
            if($key == "items") {
                foreach ($value as $key2 => $value2) {

                    if($result == "nok")
                        return "nok";

                    $soldTicketItems = new SoldTicketItems();
                    $soldTicketItems->soldTicketId = $result;

                    foreach ($value2 as $key3 => $value3) {
                        switch ($key3) {
                            case "IDNumber":
                                $soldTicketItems->IDNumber = $value3;
                                break;
                            case "direction":
                                $soldTicketItems->direction = $value3;
                                break;
                            case "age_type":
                                $soldTicketItems->ageType = $value3;
                                break;
                            case "value":
                                $soldTicketItems->value = $value3;
                                break;
                            case "title":
                                $soldTicketItems->title = $value3;
                                break;
                        }
                    }
                    try {
                        $soldTicketItems->save();
                    }
                    catch (\Exception $x) {
                        SoldTicketItems::whereSoldTicketId($result)->delete();
                        SoldTicket::destroy($result);
                        return "nok";
                    }
                }
            }
        }

        return $result;
    }

    public function tickets()
    {

        $config = ConfigModel::first();

        return view('ticket', ['adultInner' => $config->adultInner .  " +", 'childInner' => $config->childInnerMin . ' - ' . $config->childInnerMax,
            'infantInner' => '0 - ' . $config->infantInner, 'adultExternal' => '+ ' . $config->adultExternal .  " +",
            'childExternal' => $config->childExternalMin . ' - ' . $config->childExternalMax, 'infantExternal' => '0 - ' . $config->infantExternal]);
    }

    public function getTickets($mode, $src, $dest, $adult, $child, $infant, $additional, $sDate, $eDate = "", $back = "", $ticketId = "")
    {
        $source = explode('-', $src);
        $destination = explode('-', $dest);

        if(count($source) != 2 || count($destination) != 2)
            return Redirect::route('tickets');

        switch ($mode) {
            case "internalFlight":
                break;
            default:
                return Redirect::route('soon');
        }

        if(convertDateToString($sDate) < getToday()["date"])
            return Redirect::route('tickets');


        $sda = explode(',', $sDate);
        if($eDate != '')
            $eda = explode(',', $eDate);
        else
            $eda = ['', '', ''];

        $destination[1] = ltrim($destination[1], ' ');
        $source[1] = ltrim($source[1], ' ');

        include_once 'jdate.php';
        $miladiSdate = jalali_to_gregorian($sda[0], $sda[1], $sda[2]);

        if (strlen($miladiSdate[1]) == 1)
            $miladiSdate[1] = '0' . $miladiSdate[1];

        if (strlen($miladiSdate[2]) == 1)
            $miladiSdate[2] = '0' . $miladiSdate[2];

        $miladiSdate = $miladiSdate[0] . $miladiSdate[1] . $miladiSdate[2];

        if ($additional == 1) {
            $additional = 'اکونومی';
            $isBusiness = 0;
        }
        elseif ($additional == 2) {
            $additional = 'فرست کلاس';
            $isBusiness = -1;
        }
        elseif ($additional == 3) {
            $additional = 'بیزینس';
            $isBusiness = 1;
        }
        else {
            $additional = 'کلاس';
            $isBusiness = -1;
        }

        if (!empty($eDate)) {
            $miladiEdate = jalali_to_gregorian($eda[0], $eda[1], $eda[2]);

            if (strlen($miladiEdate[1]) == 1)
                $miladiEdate[1] = '0' . $miladiEdate[1];

            if (strlen($miladiEdate[2]) == 1)
                $miladiEdate[2] = '0' . $miladiEdate[2];

            $miladiEdate = $miladiEdate[0] . $miladiEdate[1] . $miladiEdate[2];

            if($isBusiness == -1)
                $ticket = InnerFlightTicket::whereFrom($source[1])->whereTo($destination[1])->where('date', '>=', $miladiSdate)
                    ->where('date', '<=', $miladiEdate)->orderBy('updated_at', 'DESC')->first();
            else
                $ticket = InnerFlightTicket::whereFrom($source[1])->whereTo($destination[1])->where('date', '>=', $miladiSdate)
                    ->where('date', '<=', $miladiEdate)->where('isBusiness', '=', $isBusiness)->orderBy('updated_at', 'DESC')->first();

        } else {
            if($isBusiness == -1)
                $ticket = InnerFlightTicket::whereFrom($source[1])->whereTo($destination[1])->where('date', '=', $miladiSdate)
                    ->orderBy('updated_at', 'DESC')->first();
            else
                $ticket = InnerFlightTicket::whereFrom($source[1])->whereTo($destination[1])->where('date', '=', $miladiSdate)
                    ->where('isBusiness', '=', $isBusiness)->orderBy('updated_at', 'DESC')->first();
        }

        $allow = true;

        if ($ticket != null) {
            $current = time() * 1000;
            if (($current - $ticket->updated_at) / 1000 < 180)
                $allow = false;
        }

        if($ticketId != '' && $back != '' && $back == 1){
            $ticketId = InnerFlightTicket::whereId($ticketId);
        }

        return view('showTicket', ['allow' => $allow, 'mode' => $mode, 'source' => $src, 'destination' => $dest, 'src' => $source, 'dest' => $destination, 'adult' => $adult,
            'child' => $child, 'infant' => $infant, 'additional' => $additional, 'sDate' => $sda, 'eDate' => $eda, 'back' => $back, 'ticketGo' => $ticketId]);
    }

    public function sendJavaRequest() {

        if(isset($_POST["sDate"]) && isset($_POST["eDate"]) && isset($_POST["src"]) && isset($_POST["dest"])) {

            $from = makeValidInput($_POST["sDate"]);

            $sDa = explode('/', $from);
            if(strlen($sDa[1]) == 1)
                $sDa[1] = '0' . $sDa[1];
            if(strlen($sDa[2]) == 1)
                $sDa[2] = '0' . $sDa[2];

            $from = $sDa[0] . '/' . $sDa[1] . '/' . $sDa[2];

            $to = makeValidInput($_POST["eDate"]);

            $eDa = explode('/', $to);
            if(strlen($eDa[1]) == 1)
                $eDa[1] = '0' . $eDa[1];
            if(strlen($eDa[2]) == 1)
                $eDa[2] = '0' . $eDa[2];

            $to = $eDa[0] . '/' . $eDa[1] . '/' . $eDa[2];

            $src = makeValidInput($_POST["src"]);
            $dest = makeValidInput($_POST["dest"]);

            $this->dispatch((new SendJavaRequest($from, $to, $src, $dest))->onQueue($from . '-' . $to . '-' . $src . '-' . $dest));
            echo "ok";
        }
    }

    public function getInnerFlightTicket() {

//        if (isset($_POST["date"]) && isset($_POST["src"]) && isset($_POST["dest"]) && isset($_POST["last"])) {

        if (isset($_POST["date"]) && isset($_POST["src"]) && isset($_POST["dest"])) {

//            $lastId = makeValidInput($_POST["last"]);

            $date = convertDateToString(makeValidInput($_POST["date"]));

            if(isset($_POST["additional"])) {
                if (makeValidInput($_POST["additional"]) == 3) {
                    $tickets = DB::select('select i1.id, i2.num from innerFlightTicket i1 JOIN (select id, flightId, count(*) as num, min(price) as minPrice from innerFlightTicket WHERE `from` = "' . makeValidInput($_POST["src"]) .
                        '" and `isBusiness` = 1 and `to` = "' . makeValidInput($_POST["dest"]) . '" and `date` = ' . $date . " and `free` > 0" .
                        ' group by(`flightId`)) i2 on i1.price = i2.minPrice and i1.flightId = i2.flightId'
                    );
                }
                elseif(makeValidInput($_POST["additional"]) != -1) {
                    $tickets = DB::select('select i1.id, i1.noTicket, i2.num from innerFlightTicket i1 JOIN (select id, flightId, noTicket, count(*) as num, min(price) as minPrice from innerFlightTicket WHERE `from` = "' . makeValidInput($_POST["src"]) .
                        '" and `isBusiness` = 0 and `to` = "' . makeValidInput($_POST["dest"]) . '" and `date` = ' . $date . " and `free` > 0" .
                        ' group by `noTicket`, `time`) i2 on i1.price = i2.minPrice and i1.noTicket = i2.noTicket'
                    );
//                    $tickets  = DB::select('SELECT min(maxPrice), id, noTicket, isBusiness, `from`, `to`, `date` FROM innerFlightTicket  WHERE `date` = ' . $date . ' and `isBusiness` = 0 and `to` = "' . makeValidInput($_POST["dest"]) . '" AND `from` = "' . makeValidInput($_POST["src"]) .'" GROUP BY noTicket, time');
                }
                else {
                    $tickets = DB::select('select i1.id, i2.num from innerFlightTicket i1 JOIN (select id, flightId, count(*) as num, min(price) as minPrice from innerFlightTicket WHERE `from` = "' . makeValidInput($_POST["src"]) .
                        '" and `to` = "' . makeValidInput($_POST["dest"]) . '" and `date` = ' . $date . " and `free` > 0" .
                        ' group by(`flightId`)) i2 on i1.price = i2.minPrice and i1.flightId = i2.flightId'
                    );
                }
            }
            else {
//                $tickets = DB::select('select i1.id, i2.num from innerFlightTicket i1 JOIN (select id, flightId, count(*) as num, min(price) as minPrice from innerFlightTicket WHERE `from` = "' . makeValidInput($_POST["src"]) .
//                    '" and `to` = "' . makeValidInput($_POST["dest"]) . '" and `date` = ' . $date . " and `free` > 0" .
//                    ' group by(`flightId`) having id > ' . $lastId . ') i2 on i1.price = i2.minPrice and i1.flightId = i2.flightId'
//                );
                $tickets = DB::select('select i1.id, i2.num from innerFlightTicket i1 JOIN (select id, flightId, count(*) as num, min(price) as minPrice from innerFlightTicket WHERE `from` = "' . makeValidInput($_POST["src"]) .
                    '" and `to` = "' . makeValidInput($_POST["dest"]) . '" and `date` = ' . $date . " and `free` > 0" .
                    ' group by(`flightId`)) i2 on i1.price = i2.minPrice and i1.flightId = i2.flightId'
                );
            }

//            dd('select i1.id, i2.num from innerFlightTicket i1 JOIN (select id, flightId, count(*) as num, min(price) as minPrice from innerFlightTicket WHERE `from` = "' . makeValidInput($_POST["src"]) .
//                '" and `to` = "' . makeValidInput($_POST["dest"]) . '" and `date` = ' . $date . " and `free` > 0" .
//                ' group by(`flightId`) having id > ' . $lastId . ') i2 on i1.price = i2.minPrice and i1.flightId = i2.flightId');
            $out = [];
            $counter = 0;

            foreach ($tickets as $ticket) {
                $tmp = InnerFlightTicket::whereId($ticket->id);
                $tmp->num = $ticket->num;
                $out[$counter++] = $tmp;
            }

            echo json_encode(["tickets" => $out]);
        }
    }

    public function getTicketWarning(){

        if(isset($_POST["from"]) && isset($_POST["to"]) && isset($_POST["date"]) && isset($_POST['email'])) {

            $from = $_POST['from'];
            $to = $_POST['to'];

            $sda = explode('/', makeValidInput($_POST["date"]));

            include_once 'jdate.php';
            $miladiSdate = jalali_to_gregorian($sda[0], $sda[1], $sda[2]);

            if (strlen($miladiSdate[1]) == 1)
                $miladiSdate[1] = '0' . $miladiSdate[1];

            if (strlen($miladiSdate[2]) == 1)
                $miladiSdate[2] = '0' . $miladiSdate[2];

            $date = $miladiSdate[0] . $miladiSdate[1] . $miladiSdate[2];
            $email = $_POST['email'];
            $otherOffer = $_POST['otherOffer'];

            if(Auth::check())
                $email = Auth::user()->email;

            if(empty($email)) {
                echo "0";
                return;
            }
//            $tmp = new TicketNotify();
//            $tmp->email = $email;
//            $tmp->date = $date;
//            $tmp->from = $from;
//            $tmp->to = $to;

            $tmp = new Notify();
            $tmp->email = $email;
            $tmp->news = 1;
            $tmp->events = 1;
            $tmp->mode = 1;

            $tmp->save();
            echo "1";
            return;

        }
    }

    public function notifyFlight($code) {

        $ticket = InnerFlightTicket::whereUniqueCode(makeValidInput($code))->first();

        if($ticket != null) {

            $emails = TicketNotify::whereFrom($ticket->from)->whereTo($ticket->to)->whereDate($ticket->date)->select('email')->get();

            foreach ($emails as $email) {
                sendMail("salam", $email->email, "تغییر قیمت");
            }
        }

    }

    public function getMinPrice() {

        if(isset($_POST["minDay"]) && isset($_POST["maxDay"]) && isset($_POST["src"]) && isset($_POST["dest"])) {

            $sda = explode('/', makeValidInput($_POST["minDay"]));
            $eda = explode('/', makeValidInput($_POST["maxDay"]));

            include_once 'jdate.php';
            $miladiSdate = jalali_to_gregorian($sda[0], $sda[1], $sda[2]);

            if (strlen($miladiSdate[1]) == 1)
                $miladiSdate[1] = '0' . $miladiSdate[1];

            if (strlen($miladiSdate[2]) == 1)
                $miladiSdate[2] = '0' . $miladiSdate[2];

            $miladiSdate = $miladiSdate[0] . $miladiSdate[1] . $miladiSdate[2];


            $miladiEdate = jalali_to_gregorian($eda[0], $eda[1], $eda[2]);

            if (strlen($miladiEdate[1]) == 1)
                $miladiEdate[1] = '0' . $miladiEdate[1];

            if (strlen($miladiEdate[2]) == 1)
                $miladiEdate[2] = '0' . $miladiEdate[2];

            $miladiEdate = $miladiEdate[0] . $miladiEdate[1] . $miladiEdate[2];

            $minPrice = DB::select('select `date`, min(`price`) as price from innerFlightTicket WHERE `from` = "' . makeValidInput($_POST["src"]) .
                '" and `to` = "' . makeValidInput($_POST["dest"]) . '" and `date` >= ' . $miladiSdate . ' and `date` <= ' . $miladiEdate .
                ' and `free` > 0 group by(`date`)'
            );

            foreach ($minPrice as $itr) {
                $tmp = gregorian_to_jalali(substr($itr->date, 0, 4), substr($itr->date, 4, 2), substr($itr->date, 6, 2));

                if (strlen($tmp[1]) == 1)
                    $tmp[1] = '0' . $tmp[1];

                if (strlen($tmp[2]) == 1)
                    $tmp[2] = '0' . $tmp[2];

                $itr->date = convertStringToDate($tmp[0] . $tmp[1] . $tmp[2]);
            }

            echo json_encode($minPrice);
        }
    }

    public function getProvidersOfSpecificFlight() {

        if(isset($_POST["flightId"])) {

            echo json_encode(InnerFlightTicket::whereFlightId(makeValidInput($_POST["flightId"]))->where('free', '>', 0)
                ->select('id', 'price', 'childPrice', 'infantPrice', 'provider')->get());

        }

    }

    private function createBackURLFromTicketId($ticket, $ticket2, $adult, $child, $infant) {

        include_once 'jdate.php';

        $date = $ticket->date;
        $year = $date[0] . $date[1] . $date[2] . $date[3];
        $month = $date[4] . $date[5];
        $day = $date[6] . $date[7];
        $jalaliDate = gregorian_to_jalali($year, $month, $day);

        if(strlen($jalaliDate[1]) == 1)
            $jalaliDate[1] = '0' . $jalaliDate[1];

        if(strlen($jalaliDate[2]) == 1)
            $jalaliDate[2] = '0' . $jalaliDate[2];

        $jalaliDate = $jalaliDate[0] . ',' . $jalaliDate[1] . ',' . $jalaliDate[2];

        $src = AirLine::whereAbbreviation($ticket->from)->first()->name . ' - ' . $ticket->from;
        $dest = AirLine::whereAbbreviation($ticket->to)->first()->name . ' - ' . $ticket->to;

        if($ticket2 != null) {

            $date = $ticket2->date;
            $year = $date[0] . $date[1] . $date[2] . $date[3];
            $month = $date[4] . $date[5];
            $day = $date[6] . $date[7];
            $jalaliDateE = gregorian_to_jalali($year, $month, $day);

            if(strlen($jalaliDateE[1]) == 1)
                $jalaliDateE[1] = '0' . $jalaliDateE[1];

            if(strlen($jalaliDateE[2]) == 1)
                $jalaliDateE[2] = '0' . $jalaliDateE[2];

            $jalaliDateE = $jalaliDateE[0] . ',' . $jalaliDateE[1] . ',' . $jalaliDateE[2];

            $backURL = route('getTickets', ['mode' => 'internalFlight', 'src' => $src, 'dest' => $dest,
                'adult' => $adult, 'child' => $child, 'infant' => $infant, 'additional' => 1, 'sDate' => $jalaliDate, 'eDate' => $jalaliDateE]);
        }
        else
            $backURL = route('getTickets', ['mode' => 'internalFlight', 'src' => $src, 'dest' => $dest,
                'adult' => $adult, 'child' => $child, 'infant' => $infant, 'additional' => 1, 'sDate' => $jalaliDate]);

        return $backURL;

    }

    public function preBuyInnerFlight($ticketId, $adult, $child, $infant, $ticketId2 = "") {

        $ticket = InnerFlightTicket::whereId($ticketId);

        $ticket2 = null;
        if($ticketId2 != "")
            $ticket2 = InnerFlightTicket::whereId($ticketId2);

        if($ticket == null || ($ticketId2 != "" && $ticket2 == null))
            return Redirect::route('tickets');

        $backURL = $this->createBackURLFromTicketId($ticket, $ticket2, $adult, $child, $infant);

        return view('pish', ['backURL' => $backURL, 'ticketId' => $ticketId, 'ticketId2' => $ticketId2,
            'adult' => $adult, 'child' => $child, 'infant' => $infant]);
    }

    public function buyInnerFlight($mode, $ticketId, $adult, $child, $infant, $ticketId2 = "") {

        $ticket = InnerFlightTicket::whereId($ticketId);

        $ticket2 = null;
        if($ticketId2 != "")
            $ticket2 = InnerFlightTicket::whereId($ticketId2);

        if($ticket == null || ($ticketId2 != "" && $ticket2 == null))
            return Redirect::route('tickets');

        $backURL = $this->createBackURLFromTicketId($ticket, $ticket2, $adult, $child, $infant);

        if(Auth::check())
            return view('pas1', ['backURL' => $backURL, 'ticket' => $ticket, 'ticket2' => $ticket2,
                'adult' => $adult, 'child' => $child, 'infant' => $infant]);

        if($mode == 2)
            return view('pas2', ['backURL' => $backURL, 'ticket' => $ticket, 'ticket2' => $ticket2,
                'adult' => $adult, 'child' => $child, 'infant' => $infant]);

        else if($mode == 1 || !Auth::check())
            return view('pas3', ['backURL' => $backURL, 'ticket' => $ticket, 'ticket2' => $ticket2,
                'adult' => $adult, 'child' => $child, 'infant' => $infant]);
    }

    public function sendPassengersInfo($ticketId) {

        if(isset($_POST["nameFa"]) && isset($_POST["nameEn"]) && isset($_POST["familyFa"]) &&
            isset($_POST["familyEn"]) && isset($_POST["NID"]) && isset($_POST["birthDay"]) &&
            isset($_POST["foreign"]) && isset($_POST["expire"]) && isset($_POST["countryCode"]) &&
            isset($_POST["sex"]) && isset($_POST["ageType"]) && isset($_POST["phoneNum"]) &&
            isset($_POST["email"]) && isset($_POST["newsMe"]) && isset($_POST["informMe"])
        ) {

            $nameFa = $_POST["nameFa"];
            $nameEn = $_POST["nameEn"];
            $familyFa = $_POST["familyFa"];
            $familyEn = $_POST["familyEn"];
            $NID = $_POST["NID"];
            $birthDay = $_POST["birthDay"];
            $foreign = $_POST["foreign"];
            $expire = $_POST["expire"];
            $countryCode = $_POST["countryCode"];
            $sex = $_POST["sex"];
            $ageType = $_POST["ageType"];
            $passengers = [];
            $newsMe = makeValidInput($_POST["newsMe"]);
            $informMe = makeValidInput($_POST["informMe"]);

            $phoneNum = makeValidInput($_POST["phoneNum"]);
            $email = makeValidInput($_POST["email"]);

            if($newsMe == "ok" || $informMe == "ok") {
                $notify = Notify::whereEmail($email)->first();
                if($notify == null) {
                    $notify = new Notify();
                    $notify->email = $email;
                }
                $notify->news = ($newsMe == "ok") ? true : false;
                $notify->events = ($informMe == "ok") ? true : false;
                $notify->save();
            }

            if(Auth::check())
                $savedInformation = $_POST["savedInformation"];


            for ($i = 0; $i < count($NID); $i++) {

                if(Auth::check()) {
                    if ($savedInformation[$i] == "ok" && Passenger::whereNID(makeValidInput($NID[$i]))->count() == 0) {
                        $passenger = new Passenger();
                        $passenger->uId = Auth::user()->id;
                        $passenger->nameFa = makeValidInput($nameFa[$i]);
                        $passenger->nameEn = makeValidInput($nameEn[$i]);
                        $passenger->familyFa = makeValidInput($familyFa[$i]);
                        $passenger->familyEn = makeValidInput($familyEn[$i]);
                        $passenger->sex = makeValidInput($sex[$i]);
                        $passenger->birthDay = convertDateToString(makeValidInput($birthDay[$i]));
                        $passenger->ageType = makeValidInput($ageType[$i]);
                        $passenger->NID = makeValidInput($NID[$i]);
                        if ($foreign[$i] == "ok") {
                            $passenger->NIDType = true;
                            $passenger->expire = convertDateToString(makeValidInput($expire[$i]));
                            $passenger->countryCodeId = makeValidInput($countryCode[$i]);
                        } else {
                            $passenger->NIDType = false;
                            $passenger->countryCodeId = CountryCode::first()->id;
                        }

                        try {
                            $passenger->save();
                        } catch (\Exception $x) {
                            dd($x->getMessage());
                        }
                    }
                }

                if ($ageType[$i] == 3)
                    $tmpAgeType = "adult";
                else if ($ageType[$i] == 2) {
                    $tmpAgeType = "child";
                    $diff = getCurrentYear() - explode('/', $birthDay[$i])[0];
                    if($diff < ConfigModel::first()->childInnerMin || $diff > ConfigModel::first()->childInnerMax) {
                        echo json_encode(['status' => "nok5", 'idx' => $i]);
                        return;
                    }
                }
                else {
                    $diff = getCurrentYear() - explode('/', $birthDay[$i])[0];
                    if($diff > ConfigModel::first()->infantInner) {
                        echo json_encode(['status' => "nok6", 'idx' => $i]);
                        return;
                    }
                    $tmpAgeType = "infant";
                }

                $tmpNIDType = ($foreign[$i] == "ok") ? 'passport' : 'national';

                if ($foreign[$i] == "ok") {
                    $passengers[$i] = ['nameFa' => $nameFa[$i], 'nameEn' => $nameEn[$i],
                        'familyFa' => $familyFa[$i], 'familyEn' => $familyEn[$i],
                        'birthDay' => $birthDay[$i], 'ageType' => $tmpAgeType,
                        'NIDType' => $tmpNIDType, 'sex' => $sex[$i], 'NID' => $NID[$i],
                        'countryCode' => makeValidInput($countryCode[$i]),
                        'passport_expire_date' => makeValidInput($expire[$i])
                    ];
                } else
                    $passengers[$i] = ['nameFa' => $nameFa[$i], 'nameEn' => $nameEn[$i],
                        'familyFa' => $familyFa[$i], 'familyEn' => $familyEn[$i],
                        'birthDay' => $birthDay[$i], 'ageType' => $tmpAgeType,
                        'NIDType' => $tmpNIDType, 'sex' => $sex[$i], 'NID' => $NID[$i]
                    ];
            }

            $flightId = InnerFlightTicket::whereId($ticketId)->uniqueKey;

            $result = $this->sendLockRequest($passengers, $phoneNum, $flightId);

            if($result != "nok") {
                $result = route('pay', ['forWhat' => 'innerTicket', 'additionalId' => $result]);
                echo json_encode(['status' => 'ok', 'result' => $result]);
            }
            else
                echo json_encode(['status' => 'nok']);
        }
    }

    public function getMyPassengers() {

        $passengers = Passenger::where('uId',Auth::user()->id)->whereSelf(false)->get();
        foreach ($passengers as $passenger)
            $passenger->countryCodeId = CountryCode::whereId($passenger->countryCodeId)->code;

        echo json_encode($passengers);
    }

    public function getMyTicketInfo() {

        $passenger = Passenger::where('uId',Auth::user()->id)->whereSelf(true)->first();
        if($passenger != null) {
            $passenger->countryCodeId = CountryCode::whereId($passenger->countryCodeId)->code;
            echo json_encode($passenger);
        }
        else
            echo json_encode([]);
    }

    public function searchCountryCode() {

        if(isset($_POST["key"])) {

            $key = makeValidInput($_POST["key"]);
            $key2 = "";

            if(isset($_POST["key2"]))
                $key2 = makeValidInput($_POST["key2"]);

            if(!empty($key2))
                echo \GuzzleHttp\json_encode(DB::select('select * from countryCode WHERE name like "%' . $key . '%" or'
                    . ' nameEn like "%' . $key . '%" or name like "%'. $key2 .'%" or nameEn like "%' .$key2 . '%"'
                ));
            else
                echo \GuzzleHttp\json_encode(DB::select('select * from countryCode WHERE name like "%' . $key . '%" or'
                    . ' nameEn like "%' . $key . '%"'
                ));
        }

    }

    public function checkInnerFlightCapacity() {

        if(isset($_POST["requested"]) && isset($_POST["ticketId"])) {

            $ticket = InnerFlightTicket::whereId(makeValidInput($_POST["ticketId"]));

            if($ticket != null) {

                if($ticket->free >= makeValidInput($_POST["requested"]))
                    echo json_encode(["status" => 'ok']);
                else if($ticket->free > 0)
                    echo json_encode(["status" => 'nok1', 'reminder' => $ticket->free]);
                else
                    echo json_encode(["status" => 'nok2']);

                return;
            }
        }

    }

}
