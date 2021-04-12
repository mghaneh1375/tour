<?php

namespace App\Http\Controllers;

use App\Events\CommentBroadCast;
use App\models\ActivationCode;
use App\models\Activity;
use App\models\Adab;
use App\models\AirLine;
use App\models\Alert;
use App\models\localShops\LocalShopsCategory;
use App\models\places\Amaken;
use App\models\BannerPics;
use App\models\places\Boomgardy;
use App\models\Cities;
use App\models\CityPic;
use App\models\ConfigModel;
use App\models\DefaultPic;
use App\models\FoodMaterial;
use App\models\FoodMaterialRelation;
use App\models\GoyeshCity;
use App\models\places\Hotel;
use App\models\places\HotelApi;
use App\models\LogFeedBack;
use App\models\LogModel;
use App\models\places\MahaliFood;
use App\models\MainSliderPic;
use App\models\places\Majara;
use App\models\Message;
use App\models\OpOnActivity;
use App\models\places\Place;
use App\models\places\PlacePic;
use App\models\places\PlaceTag;
use App\models\PostComment;
use App\models\Question;
use App\models\Report;
use App\models\ReportsType;
use App\models\places\Restaurant;
use App\models\RetrievePas;
use App\models\Reviews\ReviewUserAssigned;
use App\models\safarnameh\Safarnameh;
use App\models\safarnameh\SafarnamehCategories;
use App\models\safarnameh\SafarnamehCategoryRelations;
use App\models\safarnameh\SafarnamehCityRelations;
use App\models\places\SogatSanaie;
use App\models\State;
use App\models\Train;
use App\models\Trip;
use App\models\TripMember;
use App\models\User;
use App\models\saveApiInfo;
use Carbon\Carbon;
use Exception;
use Google_Client;
use Google_Service_Oauth2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Assign;
use function Sodium\crypto_box_publickey_from_secretkey;


class HomeController extends Controller
{
    public function mainSliderStore(Request $request)
    {
//        dd($request->all());
        if(\auth()->check() && \auth()->user()->level == 1) {
            $location = __DIR__ . '/../../../../assets/_images/sliderPic';

            if(!file_exists($location))
                mkdir($location);

            if(isset($request->id) && $request->id != 0){
                $slider = MainSliderPic::find($request->id);
                if($slider != null){
                    $slider->text = $request->text;
                    $slider->textBackground = $request->color;
                    $slider->textColor = $request->textColor;
                    $slider->alt = 'کوچیتا';

                    if (isset($_FILES['pic']) && $_FILES['pic']['error'] == 0){
                        if (is_file($location . '/' . $slider->pic))
                            unlink($location . '/' . $slider->pic);
                        $fileName =  time() . $_FILES['pic']['name'];
                        $destinationPic = $location . '/' . $fileName;
                        move_uploaded_file( $_FILES['pic']['tmp_name'], $destinationPic);
                        $slider->pic = $fileName;
                    }

                    if (isset($_FILES['backPic']) && $_FILES['backPic']['error'] == 0){
                        if (is_file($location . '/' . $slider->backgroundPic))
                            unlink($location . '/' . $slider->backgroundPic);
                        $fileName =  (time()+1) . $_FILES['backPic']['name'];
                        $destinationPic = $location . '/' . $fileName;
                        move_uploaded_file( $_FILES['backPic']['tmp_name'], $destinationPic);
                        $slider->backgroundPic = $fileName;
                    }
                    $slider->save();
                    echo json_encode(['ok', $slider->id]);
                }
                else
                    echo json_encode(['nok1']);

            }
            else if(isset($request->id) && $request->id == 0){
                if (isset($_FILES['pic']) && $_FILES['pic']['error'] == 0){
                    $slider = new MainSliderPic();
                    $slider->text = $request->text;
                    $slider->textBackground = $request->color;
                    $slider->textColor = $request->textColor;
                    $slider->alt = 'کوچیتا';

                    $fileName =  time() . $_FILES['pic']['name'];
                    $destinationPic = $location . '/' . $fileName;
                    move_uploaded_file($_FILES['pic']['tmp_name'], $destinationPic);
//                    compressImage($_FILES['pic']['tmp_name'], $destinationPic, 80);
                    $slider->pic = $fileName;

                    if (isset($_FILES['backPic']) && $_FILES['backPic']['error'] == 0){
                        $fileName =  (time()+1) . $_FILES['backPic']['name'];
                        $destinationPic = $location . '/' . $fileName;
                        move_uploaded_file( $_FILES['backPic']['tmp_name'], $destinationPic);
                        $slider->backgroundPic = $fileName;
                    }

                    $slider->save();

                    echo json_encode(['ok', $slider->id]);
                }

            }
            else
                echo json_encode(['nok2']);
        }
        else
            echo json_encode(['nok3']);

        return;
    }

    public function mainSliderImagesDelete(Request $request){
        if(isset($request->id) && $request->id != 0){
            $slider = MainSliderPic::find($request->id);
            if($slider != null){
                $location = __DIR__ . '/../../../../assets/_images/sliderPic';

                if (file_exists($location . '/' . $slider->pic))
                    unlink($location . '/' . $slider->pic);

                if (file_exists($location . '/' . $slider->backgroundPic))
                    unlink($location . '/' . $slider->backgroundPic);

                $slider->delete();
                echo 'ok';
            }
            else
                echo 'nok2';
        }
        else
            echo 'nok1';

        return;
    }

    public function middleBannerImages(Request $request)
    {
        if(\auth()->check() && \auth()->user()->level == 1){
            $location = __DIR__ . '/../../../../assets/_images/bannerPic';

            if(!file_exists($location))
                mkdir($location);

            $location .= '/' . $request->page;

            if(!file_exists($location))
                mkdir($location);

            if(isset($request->id) && $request->id != 0){
                $pic = BannerPics::find($request->id);
                if($pic != null){
                    $link = $request->link;
                    if (strpos($link, 'http') === false)
                        $link = 'https://' . $link;

                    $pic->link = $link;
                    $pic->text = $request->text;
                    if (isset($_FILES['pic']) && $_FILES['pic']['error'] == 0){
                        if (file_exists($location . '/' . $pic->pic))
                            unlink($location . '/' . $pic->pic);

                        $fileName =  time() . $_FILES['pic']['name'];
                        $destinationPic = $location . '/' . $fileName;
                        move_uploaded_file($_FILES['pic']['tmp_name'], $destinationPic);

//                        compressImage($_FILES['pic']['tmp_name'], $destinationPic, 80);
                        $pic->pic = $fileName;
                    }
                    $pic->save();
                    echo json_encode(['ok', $pic->id]);
                }
                else
                    echo 'nok5';

                return;
            }
            else {
                if (isset($_FILES['pic']) && $_FILES['pic']['error'] == 0) {

                    $pic = new BannerPics();
                    $pic->page = $request->page;
                    $pic->section = $request->section;
                    $pic->number = $request->number;
                    $fileName =  time() . $_FILES['pic']['name'];
                    $destinationPic = $location . '/' . $fileName;
                    move_uploaded_file($_FILES['pic']['tmp_name'], $destinationPic);

//                    compressImage($_FILES['pic']['tmp_name'], $destinationPic, 80);
                    $pic->pic = $fileName;

                    $link = $request->link;
                    if (strpos($link, 'http') === false)
                        $link = 'https://' . $link;

                    $pic->link = $link;
                    $pic->userId = \auth()->user()->id;
                    $pic->text = $request->text;

                    $pic->save();

                    echo json_encode(['ok', $pic->id]);
                }
                else if (isset($request->link) && isset($request->id)) {
                    $pic = BannerPics::find($request->id);
                    if ($pic != null) {
                        $link = $request->link;
                        if (strpos($link, 'http') === false)
                            $link = 'https://' . $link;
                        $pic->link = $link;
                        $pic->text = $request->text;

                        $pic->save();
                    } else
                        echo json_encode(['nok2']);

                    echo json_encode(['ok', $pic->id]);
                }
                else
                    echo json_encode(['nok3']);
            }

        }
        else
            echo json_encode(['nok1']);

        return;
    }

    public function middleBannerImagesDelete(Request $request)
    {
        if(isset($request->id) && \auth()->check() && \auth()->user()->level == 1){
            $location = __DIR__ . '/../../../../assets/_images/bannerPic';
            $pic = BannerPics::find($request->id);
            if($pic != null){
                $location .= '/' . $pic->page;
                if (file_exists($location . '/' . $pic->pic))
                    unlink($location . '/' . $pic->pic);
                $pic->delete();
                echo 'ok';
            }
            else
                echo 'nok2';
        }
        else
            echo 'nok1';

        return;
    }

    public function checkUserNameAndPass()
    {

        if (isset($_POST["username"]) && isset($_POST["pass"]) && isset($_POST["rPass"])) {

            $username = makeValidInput($_POST["username"]);
            $pass = makeValidInput($_POST["pass"]);
            $rPass = makeValidInput($_POST["rPass"]);

            if (User::whereUserName($username)->count() > 0) {
                echo "nok1";
                return;
            }

            if ($pass != $rPass) {
                echo "nok2";
                return;
            }

            $user = new User();
            $user->username = $username;
            $user->password = Hash::make($pass);
            $user->cityId = Cities::first()->id;
            if(request('email') != null && request('phone') != null){
                $user->email = request('email');
                $user->phone = request('phone');
            }
            if(request('firstName') != null && request('lastName') != null){
                $user->first_name = request('firstName');
                $user-> last_name  = request('lastName');
            }

            try {
                $user->save();
                echo "ok";
            } catch (\Exception $x) {
                dd($x);
            }
        }

    }

    public function searchForStates()
    {
        if (isset($_POST["key"])) {
            $key = makeValidInput($_POST["key"]);
            echo json_encode(DB::select("select * from states WHERE name LIKE '%$key%'"));
        }
    }

    public function testHotel()
    {

        $hotels = DB::select('select h.name as hotelName, c.name as cityName from hotels h, cities c WHERE h.cityId = c.id limit 0, 20');

        $data = array(
            'request' => 'getHotelsPrices',
            'username' => 'mohammad',
            'password' => '22743823',
            'hotels' => json_encode($hotels)
        );


        $this->sendPostRequest('http://localhost:8080/proxy/', $data);
    }

    function sendPostRequest($url, $data)
    {
        //open connection
        $ch = curl_init();

        $postString = http_build_query($data, '', '&');

//set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
        $result = curl_exec($ch);
        print $result;
        curl_close($ch);
    }

    public function showPoliciess()
    {
        return view('policies2');
    }

    public function removeDuplicate($key)
    {

        $hotels = DB::select('select h2.id from ' . $key . ' h1, ' . $key . ' h2 WHERE h2.id > h1.id and h1.name = h2.name');

        echo count($hotels);

        switch ($key) {
            case "hotels":
                foreach ($hotels as $hotel)
                    Hotel::destroy($hotel->id);
                break;
            case "amaken":
                foreach ($hotels as $hotel)
                    Amaken::destroy($hotel->id);
                break;
            case "restaurant":
                foreach ($hotels as $hotel)
                    Restaurant::destroy($hotel->id);
                break;
            case "adab":
                foreach ($hotels as $hotel)
                    Adab::destroy($hotel->id);
                break;
            case "majara":
                foreach ($hotels as $hotel)
                    Majara::destroy($hotel->id);
                break;
        }

        return;
    }

    public function export($mode)
    {

        $serverName = "localhost";
        $username = "root";
        $password = '';
        $dbName = "admin_shazde";

        $conn = mysqli_connect($serverName, $username, $password);

        $conn->set_charset("utf8");
        mysqli_select_db($conn, $dbName) or die("Connection failed: ");

        $dbLink = $conn;

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Gachesefid");
        $objPHPExcel->getProperties()->setLastModifiedBy("Gachesefid");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

        $objPHPExcel->setActiveSheetIndex(0);

        if ($mode == "hotel")
            $query = "select * from hotels";
        else if ($mode == "amaken")
            $query = "select * from amaken";
        else if ($mode == "majara")
            $query = "select * from majara";
        else if ($mode == "adab")
            $query = "select * from majara";
        else if ($mode == "restaurant")
            $query = "select * from restaurant";

        $result = mysqli_query($dbLink, $query);

        $counter = 1;

        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            'AA', 'BB', 'CC', 'DD', 'EE', 'FF', 'GG', 'HH', 'II', 'JJ', 'KK', 'LL', 'MM', 'NN', 'OO', 'PP', 'QQ', 'RR', 'SS', 'TT', 'UU', 'VV', 'WW', 'XX', 'YY', 'ZZ'
        ];

        while ($row = mysqli_fetch_row($result)) {

            for ($i = 0; $i < count($row); $i++) {
                $objPHPExcel->getActiveSheet()->setCellValue($cols[$i] . ($counter), $row[$i]);
            }

            $counter++;

        }

        $fileName = __DIR__ . "/../../../public/" . $mode . ".xlsx";

        $objPHPExcel->getActiveSheet()->setTitle('گزارش گیری پایه تحصیلی');

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
    }

    public function fillState()
    {

        $path = __DIR__ . '/../../../../assets/alaki.xlsx';

        $excelReader = PHPExcel_IOFactory::createReaderForFile($path);
        $excelObj = $excelReader->load($path);
        $workSheet = $excelObj->getSheet(0);

        $lastRow = $workSheet->getHighestRow();

        for ($row = 1; $row <= $lastRow; $row++) {
            $tmp = $workSheet->getCell('A' . $row)->getValue();
            $alaki = new State();
            $str = explode(' ', $tmp);
            $tmp = "";
            for ($i = 1; $i < count($str); $i++) {
                if ($i != count($str) - 1)
                    $tmp .= $str[$i] . " ";
                else
                    $tmp .= $str[$i];
            }
            $alaki->name = $tmp;
            $alaki->save();
        }

    }

    public function fillTrain()
    {

        $path = __DIR__ . '/../../../../assets/alaki.xlsx';

        $excelReader = PHPExcel_IOFactory::createReaderForFile($path);
        $excelObj = $excelReader->load($path);
        $workSheet = $excelObj->getSheet(0);

        $lastRow = $workSheet->getHighestRow();

        for ($row = 1; $row <= $lastRow; $row++) {
            $name = $workSheet->getCell('A' . $row)->getValue();

            $alaki = new Train();

            $alaki->name = $name;
            try {
                $alaki->save();
            } catch (Exception $x) {
                echo $x->getMessage() . "<br/>";
            }
        }
    }

    public function fillAirLine()
    {

        $path = __DIR__ . '/../../../../assets/alaki.xlsx';

        $excelReader = PHPExcel_IOFactory::createReaderForFile($path);
        $excelObj = $excelReader->load($path);
        $workSheet = $excelObj->getSheet(0);

        $lastRow = $workSheet->getHighestRow();

        for ($row = 1; $row <= $lastRow; $row++) {
            $name = $workSheet->getCell('A' . $row)->getValue();
            $abbreviation = $workSheet->getCell('B' . $row)->getValue();

            $alaki = new AirLine();

            $alaki->name = $name;
            $alaki->abbreviation = $abbreviation;

            try {
                $alaki->save();
            } catch (Exception $x) {
                echo $x->getMessage() . "<br/>";
            }
        }
    }

    public function fillCity()
    {

        $path = __DIR__ . '/../../../../assets/alaki.xlsx';

        $excelReader = PHPExcel_IOFactory::createReaderForFile($path);
        $excelObj = $excelReader->load($path);
        $workSheet = $excelObj->getSheet(0);

        $lastRow = $workSheet->getHighestRow();

        for ($row = 1; $row <= $lastRow; $row++) {
            $name = $workSheet->getCell('A' . $row)->getValue();
            $C = $workSheet->getCell('B' . $row)->getValue();
            $D = $workSheet->getCell('C' . $row)->getValue();
            $stateId = $workSheet->getCell('D' . $row)->getValue();

            $alaki = new Cities();

            $alaki->name = $name;
            $alaki->x = $C;
            $alaki->y = $D;
            $alaki->stateId = $stateId;
            try {
                $alaki->save();
            } catch (Exception $x) {
                echo $x->getMessage() . "<br/>";
            }
        }

    }

    public function updateHotelsFile()
    {

        $hotels = Hotel::get();
        foreach ($hotels as $hotel) {

            $tmp = explode(' ', $hotel->file);

            $str = "";
            for ($i = 0; $i < count($tmp); $i++) {
                if (count($tmp) - 1 == $i)
                    $str .= $tmp[$i];
                else
                    $str .= $tmp[$i] . '_';
            }

            $hotel->file = $str;
            try {
                $hotel->save();
            } catch (Exception $x) {
                echo $x->getMessage();
            }
        }
    }

    public function updateAmakensFile()
    {

        $amakens = Amaken::get();
        foreach ($amakens as $hotel) {

            $tmp = explode(' ', $hotel->file);

            $str = "";
            for ($i = 0; $i < count($tmp); $i++) {
                if (count($tmp) - 1 == $i)
                    $str .= $tmp[$i];
                else
                    $str .= $tmp[$i] . '_';
            }

            $hotel->file = $str;
            try {
                $hotel->save();
            } catch (Exception $x) {
                echo $x->getMessage();
            }
        }
    }

    public function estelahat($goyesh)
    {

        $tags = DB::select('select DISTINCT goyeshTag.id, goyeshTag.name from goyeshTag, goyeshCity, estelahat WHERE goyeshCity.name = "' . $goyesh . '" and goyeshTag.id = tagId and goyeshId = goyeshCity.id');

        foreach ($tags as $tag) {
            $tag->words = DB::select('select estelah, talafoz, maani from goyeshCity, estelahat WHERE goyeshCity.name = "' . $goyesh . '" and tagId = ' . $tag->id . ' and goyeshId = goyeshCity.id');
        }

        return view('estelahat', array('goyesh' => $goyesh, 'tags' => $tags, 'goyeshCities' => GoyeshCity::all()));
    }

    public function soon()
    {
        return view('errors.underConstruction');
    }

    public function printPage($tripId)
    {
        return view('alaki', array('tripId' => $tripId));
    }

    public function totalSearch(Request $request)
    {
        if ((isset($_POST["key"]) && isset($_POST["kindPlaceId"])) || (isset($request->key) && isset($request->kindPlaceId))) {

            $kindPlaceId = isset($_POST["kindPlaceId"]) ? makeValidInput($_POST["kindPlaceId"]) : makeValidInput($request->kindPlaceId);
            $key = isset($_POST["key"]) ? makeValidInput($_POST["key"]) : makeValidInput($request->key);
            $key2 = (isset($_POST["key2"]) ? makeValidInput($_POST["key2"]) : (isset($request->key2) ? makeValidInput($request->key2) : ''));

            $time = time();

            $key = str_replace(' ', '', $key);
            $key2 = str_replace(' ', '', $key2);

            if (!empty($key2))
                $result = DB::select("SELECT `name` as targetName, id, isCountry from state WHERE replace(`name`, ' ', '') LIKE '%$key%' or replace(`name`, ' ', '') LIKE '%$key2%'");
            else
                $result = DB::select("SELECT `name` as targetName, id, isCountry from state WHERE replace(`name`, ' ', '') LIKE '%$key%'");

            foreach ($result as $itr) {
                $itr->mode = "state";
                $itr->kindPlaceId = -1;
                $itr->url = createUrl(0, 0, $itr->id, 0, 0);
            }

            if (!empty($key2))
                $tmp = DB::select("SELECT cities.name as targetName, state.name as stateName, cities.id as id from cities, state WHERE (replace(cities.name, ' ', '') LIKE '%$key%' or replace(cities.name, ' ', '') LIKE '%$key2%') and stateId = state.id and isVillage = 0");
            else
                $tmp = DB::select("SELECT cities.name as targetName, state.name as stateName, cities.id as id from cities, state WHERE replace(cities.name, ' ', '') LIKE '%$key%' and  stateId = state.id and isVillage = 0");

            foreach ($tmp as $itr) {
                $itr->amakenCount = Amaken::where('cityId', $itr->id)->count();
                $itr->mode = "city";
                $itr->kindPlaceId = 0;
                $itr->url = createUrl(0, 0, 0,  $itr->id, 0);
            }
            for($i = 0; $i < count($tmp); $i++){
                for($j = 1; $j < count($tmp); $j++){
                    if($tmp[$i]->amakenCount < $tmp[$j]->amakenCount){
                        $t = $tmp[$i];
                        $tmp[$i] = $tmp[$j];
                        $tmp[$j] = $t;
                    }
                }
            }

            $result = array_merge($result, $tmp);

            $kinPlace = Place::whereNotNull('tableName')->where('mainSearch', 1)->get();

            foreach ($kinPlace as $kplace){
                if($kindPlaceId == 0 || $kplace->id == $kindPlaceId) {
                    $selector = " tableName.id, tableName.name as targetName";
                    $tableQuery = '';
                    $sqlQuery = '';
                    if($kplace->id != 14){
                        $selector .= " , cities.name as cityName, state.name as stateName, cities.id as cityId";
                        $sqlQuery = "cityId = cities.id and state.id = cities.stateId AND ";
                        $tableQuery = ', cities, state';
                    }
                    if($kplace->id == 13)
                        $sqlQuery .= " tableName.categoryId = 280 AND ";

                    $sqlQuery .= " ( replace(tableName.name, ' ', '') LIKE '%{$key}%'";
                    if (!empty($key2))
                        $sqlQuery .= " OR replace(tableName.name, ' ', '') LIKE '%{$key2}%'";
                    $sqlQuery .= ')';

                    $tmp = DB::select("SELECT {$selector} from {$kplace->tableName} as tableName {$tableQuery} WHERE {$sqlQuery}");
                    foreach ($tmp as $itr) {
                        $itr->see = 0;
                        $itr->mode = $kplace->tableName;
                        $itr->kindPlaceId = $kplace->id;
                        $itr->url = createUrl($kplace->id, $itr->id, 0, 0, 0);
                    }
                    $result = array_merge($result, $tmp);
                }
            }

            echo json_encode([$time, $result, $request->num]);
        }
    }


    public function getAlerts()
    {
        $result = [];
        $greenColor = '#4dc7bc47';
        $redColor = '#ffe1e1';
        $alerts = Alert::where('userId', \auth()->user()->id)->orderByDesc('id')->get();

        foreach ($alerts as $item) {
            $item->time = getDifferenceTimeString($item->created_at);

            if($item->subject == 'deleteReview' || $item->subject == 'deleteAns' || $item->subject == 'deleteQues'){
                if($item->subject == 'deleteReview' && $item->referenceTable == 'free'){
                    $item->color = $redColor;
                    $item->msg = 'پست شما حذف شد';
                    $item->pic = \URL::asset('images/mainPics/noPicSite.jpg');
                    array_push($result, $item);
                }
                else {
                    $reference = \DB::table($item->referenceTable)->find($item->referenceId);
                    if ($reference != null) {
                        $kindPlace = Place::where('tableName', $item->referenceTable)->first();
                        $placeId = $reference->id;
                        $place = \DB::table($kindPlace->tableName)->find($placeId);
                        $placeUrl = createUrl($kindPlace->id, $placeId, 0, 0, 0);

                        if ($item->subject == 'deleteReview')
                            $refType = 'دیدگاه';
                        else if ($item->subject == 'deleteAns')
                            $refType = 'پاسخ';
                        else if ($item->subject == 'deleteQues')
                            $refType = 'سوال';

                        $alertText = $refType . ' شما برای ' . '<a href="' . $placeUrl . '" class="alertUrl">' . $place->name . '</a>' . ' بدلیل مغایرت با قوانین سایت حذف گردید.';

                        $item->color = $redColor;
                        $item->msg = $alertText;
                        $item->pic = getPlacePic($placeId, $kindPlace->id, 'l');
                        array_push($result, $item);
                    }
                    else
                        $item->delete();
                }
            }
            else if($item->subject == 'assignedUserToReview'){
                $reference = ReviewUserAssigned::find($item->referenceId);
                if($reference != null){
                    $assigned = $reference;
                    $log = LogModel::find($assigned->logId);
                    if($log != null){
                        $rUser = User::find($log->visitorId);

                        $alertTTT = '';
                        if($log->kindPlaceId != 0 && $log->placeId != 0){
                            $kindPlace = Place::find($log->kindPlaceId);
                            $place = \DB::table($kindPlace->tableName)->find($log->placeId);

                            if($kindPlace != null && $place != null){
                                $placeUrl = createUrl($kindPlace->id, $place->id, 0, 0, 0);
                                $alertTTT = ' در ' . '<a href="' . $placeUrl . '" class="alertUrl">' . $place->name . '</a>';
                            }
                            else
                                $item->delete();

                            $item->pic = getPlacePic($place->id, $kindPlace->id, 'l');
                        }
                        else
                            $item->pic = \URL::asset('images/mainPics/noPicSite.jpg');

                        $alertText = $rUser->username . ' شما را در پست خود ' . $alertTTT . 'تگ کرده است.';
                        $item->color = $greenColor;
                        $item->msg = $alertText;
                        array_push($result, $item);
                    }
                    else
                        $item->delete();
                }
                else
                    $item->delete();
            }
            else if($item->referenceTable == 'log'){
                $reference = LogModel::find($item->referenceId);
                if($reference != null) {

                    $setPlace = false;
                    $linkInMsg = '';
                    if($reference->kindPlaceId != 0 && $reference->placeId != 0){
                        $kindPlaceId = $reference->kindPlaceId;
                        $placeId = $reference->placeId;
                        $kindPlace = Place::find($kindPlaceId);
                        $place = \DB::table($kindPlace->tableName)->find($placeId);
                        $placeUrl = route('placeDetails', ['kindPlaceId' => $kindPlaceId, 'placeId' => $placeId]);

                        $linkInMsg = ' برای ' . "<a href='{$placeUrl}' class='alertUrl'>{$place->name}</a>";
                        $setPlace = true;
                    }


                    if ($item->subject == 'addReview' || $item->subject == 'addQuestion' || $item->subject == 'addAns'){
                        if($item->subject == 'addReview')
                            $refName = 'دیدگاه';
                        else if($item->subject == 'addQuestion')
                            $refName = 'سوال';
                        else if($item->subject == 'addAns')
                            $refName = 'پاسخ';

                        $alertText = $refName . ' شما با موفقیت ' . $linkInMsg . 'ثبت گردید.';
                        $item->color = $greenColor;
                    }
                    else if ($item->subject == 'deleteReviewPic') {
                        $alertText = 'عکسی از دیدگاه شما ' . $linkInMsg . 'به دلیل مغایرت با قوانین سایت حذف گردید.';
                        $item->color = $redColor;
                    }
                    else if ($item->subject == 'deleteReviewVideo') {
                        $alertText = 'ویدیویی از دیدگاه شما ' . $linkInMsg . 'به دلیل مغایرت با قوانین سایت حذف گردید.';
                        $item->color = $redColor;
                    }
                    else if ($item->subject == 'addReport') {
                        $alertText = 'گزارش شما برای پستی در ' . $linkInMsg . ' با موفقیت ثبت شد.';
                        $item->color = $greenColor;
                    }
                    else if ($item->subject == 'confirmReport') {
                        $alertText = 'گزارش شما برای پستی در ' . $linkInMsg . ' در حال بررسی می باشد. با تشکر از همکاری شما.';
                        $item->color = $greenColor;
                    }
                    else if($item->subject == 'ansAns'){
                        $uRef = User::find($reference->visitorId);
                        $reviewActivity = Activity::where('name', 'نظر')->first();
                        $ansActivity = Activity::where('name', 'پاسخ')->first();
                        $quesActivity = Activity::where('name', 'سوال')->first();
                        $releatedLog = LogModel::find($reference->relatedTo);

                        if($releatedLog->activityId == $reviewActivity->id)
                            $alertText = $uRef->username . ' برای دیدگاه شما در '.$linkInMsg.' نظر نوشت.';
                        if($releatedLog->activityId == $quesActivity->id)
                            $alertText = $uRef->username . ' برای سوال شما در '.$linkInMsg.' پاسخ نوشت.';
                        else if($releatedLog->activityId == $ansActivity->id){

                            $notAns = LogModel::find($releatedLog->relatedTo);
                            while(true){
                                if($notAns->activityId != $ansActivity->id)
                                    break;
                                $notAns = LogModel::find($notAns->relatedTo);
                            }

                            if($notAns->activityId == $reviewActivity->id) {
                                $refRefKind = ' دیدگاه ';
                                $refKind = 'نظر' ;
                            }
                            else if($notAns->activityId == $quesActivity->id) {
                                $refRefKind = ' سوال ';
                                $refKind = 'پاسخ' ;
                            }

                            $refrefUser = User::find($notAns->visitorId);

                            $alertText = $uRef->username . ' برای ' . $refKind . ' شما در ' . $refRefKind . $refrefUser->username;
                            if($setPlace)
                                $alertText .= ' در '. '<a href="' . $placeUrl . '" class="alertUrl">' . $place->name . '</a>';
                            $alertText .= '.پاسخ نوشت';
                        }

                        $item->color = $greenColor;
                    }

                    if(isset($alertText)) {
                        $item->msg = $alertText;
                        $item->pic = $setPlace ? getPlacePic($placeId, $kindPlaceId, 'l') : \URL::asset("images/mainPics/noPicSite.jpg");

                        array_push($result, $item);
                    }
                }
                else
                    $item->delete();
            }
            else if($item->referenceTable == 'logFeedBack'){
                $reference = LogFeedBack::find($item->referenceId);
                if($reference != null){
                    $referenceLog = LogModel::find($reference->logId);
                    if($referenceLog != null){

                        $setPlace = false;
                        if($referenceLog->kindPlaceId != 0 && $referenceLog->placeId != 0) {
                            $kindPlaceId = $referenceLog->kindPlaceId;
                            $placeId = $referenceLog->placeId;
                            $kindPlace = Place::find($kindPlaceId);
                            $place = \DB::table($kindPlace->tableName)->find($placeId);
                            $placeUrl = createUrl($kindPlaceId, $placeId, 0, 0, 0);
                            $setPlace = true;
                        }

                        if ($item->subject == 'likeReview' || $item->subject == 'dislikeReview') {
                            $uRef = User::find($reference->userId);
                            $alertText = $uRef->username . ' دیدگاه شما را ';
                            if($setPlace)
                                $alertText .= ' در ' . "  <a href='{$placeUrl}' class='alertUrl'>{$place->name}</a>";

                            $alertText .= strpos($item->subject, 'dislike') !== false ? ' نپسندید.' : ' پسندید.';
                            $item->color = $greenColor;
                        }
                        else if ($item->subject == 'likeAns' || $item->subject == 'dislikeAns') {
                            $uRef = User::find($reference->userId);
                            $reviewActivity = Activity::where('name', 'نظر')->first();
                            $ansActivity = Activity::where('name', 'پاسخ')->first();
                            $quesActivity = Activity::where('name', 'سوال')->first();
                            $releatedLog = LogModel::find($reference->logId);

                            if ($releatedLog->activityId == $reviewActivity->id)
                                $alertText = $uRef->username . ' دیدگاه شما را در ';
                            if ($releatedLog->activityId == $quesActivity->id)
                                $alertText = $uRef->username . ' سوال شما را در ';
                            else if ($releatedLog->activityId == $ansActivity->id) {
                                $notAns = LogModel::find($releatedLog->relatedTo);
                                while (true) {
                                    if ($notAns->activityId != $ansActivity->id)
                                        break;
                                    $notAns = LogModel::find($notAns->relatedTo);
                                }

                                if ($notAns->activityId == $reviewActivity->id) {
                                    $refRefKind = ' دیدگاه ';
                                    $refKind = 'نظر';
                                }
                                else if ($notAns->activityId == $quesActivity->id) {
                                    $refRefKind = ' سوال ';
                                    $refKind = 'پاسخ';
                                }
                                $refrefUser = User::find($notAns->visitorId);
                                $alertText = $uRef->username  . $refKind . ' شما را در ' . $refRefKind . $refrefUser->username;
                            }

                            if($setPlace)
                                $alertText .= ' در ' . "  <a href='{$placeUrl}' class='alertUrl'>{$place->name}</a>";

                            $alertText .= strpos($item->subject, 'dislike') !== false ? ' نپسندید.' : ' پسندید.';
                            $item->color = $greenColor;
                        }

                        if(isset($alertText)) {
                            $item->msg = $alertText;
                            $item->pic = $setPlace ? getPlacePic($placeId, $kindPlaceId, 'l') : \URL::asset("images/mainPics/noPicSite.jpg");
                            array_push($result, $item);
                        }
                    }
                    else
                        $item->delete();
                }
                else
                    $item->delete();
            }
            else if($item->referenceTable == 'messages'){
                $reference = Message::find($item->referenceId);
                if($reference != null){
                    if($reference->senderId == 0){
                        $url = route('profile.message.page');
                        $alertText = '<a href="' . $url . '">';
                        $alertText .= 'شما یک پیام از کوچیتا دارید.';
                        $alertText .= '</a>';

                        $item->color = $greenColor;
                        $item->msg = $alertText;
                        $item->pic = getUserPic(0);
                        array_push($result, $item);
                    }
                    else {
                        $uRef = User::find($reference->senderId);
                        $url = route('profile.message.page') . '?user=' . $uRef->username;
                        $alertText = '<a href="' . $url . '">';
                        $alertText .= 'شما یک پیام از ' . $uRef->username . ' دارید.';
                        $alertText .= '</a>';

                        $item->color = $greenColor;
                        $item->msg = $alertText;
                        $item->pic = getUserPic($reference->senderId);
                        array_push($result, $item);
                    }
                }
                else
                    $item->delete();
            }
            else if($item->subject == 'deleteFromTrip'){
                $reference = Trip::find($item->referenceId);
                if($reference != null){
                    $alertText = 'شما از برنامه سفر ' . $reference->name . ' حذف شدید.';

                    $item->color = $redColor;
                    $item->msg = $alertText;
                    $item->pic = getUserPic(0);
                    array_push($result, $item);
                }
                else
                    $item->delete();
            }
            else if($item->subject == 'inviteToTrip'){
                $reference = Trip::find($item->referenceId);
                if($reference != null){
                    $alertText = '<a href="' . route("tripPlaces", ['tripId' => $reference->id]) . '">';
                    $alertText .= 'شما به برنامه سفر ' . $reference->name . ' دعوت شدید.';
                    $alertText .= '</a>';

                    $item->color = $greenColor;
                    $item->msg = $alertText;
                    $item->pic = getUserPic(0);
                    array_push($result, $item);
                }
                else
                    $item->delete();
            }


            if(count($result) == 5)
                break;
        }

        return response()->json(['status' => 'ok', 'result' => $result]);
    }

    public function seenAlerts(Request $request)
    {
        if(isset($request->id) && isset($request->kind)){
            if($request->kind == 'seen')
                Alert::where('userId', \auth()->user()->id)->where('seen', 0)->update(['seen' => 1]);
            else
                Alert::find($request->id)->update(['click' => 1]);

            return response()->json(['status' => 'ok']);
        }
        else
            return response()->json(['status' => 'nok']);
    }



    public function getHotelDetailsApi()
    {
        $access_token = $this->getAccessTokenHotel();
        $city = $this->getCityCodeApi($access_token);

        for($i = 0; $i < count($city); $i++){
            $this->getHotelCity($city[$i]->id, $access_token, $city[$i]->persinaTitle);
        }

        dd("end");
    }
    private function getAccessTokenHotel()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.altrabo.com/api/v1/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "username=testapi&password=%40ltrab0Test&client_id=00000&grant_type=password&undefined=",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Postman-Token: 30f7d799-43cc-4f98-bc59-74e794acb868",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $access_token_save = saveApiInfo::whereName('access_token_ali_baba')->first();
        if($access_token_save == null){
            $newSave = new saveApiInfo();
            $newSave->name = 'access_token_ali_baba';
            $newSave->array = $response;

            $newSave->save();
        }

        if ($err) {
            dd('err  = ' . $err);
        } else {
            $access_token = json_decode($response)->access_token;
        }
        return $access_token;
    }
    private function getCityCodeApi($access_token)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.altrabo.com/api/v1/HotelAvailable/AutoComplete?isDomestic=true&query=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: 226a3dda-b179-4c96-8bee-38bb92be81c9",
                "X-ZUMO-AUTH:" . $access_token,
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $city = $response->data;
        }

        return $city;
    }
    private function getHotelCity($city_id, $access_token, $city_name){

        $nowDate = date("Y-m-d");
        $tomorrowDate = date("Y-m-d", strtotime("tomorrow"));
        $hotel_input = array('CheckIn' => $nowDate,
            'CheckOut' => $tomorrowDate,
            'CityIdOrHotelId' => $city_id,
            'Nationality' => 'IR',
            'IsDomestic' => 'true'
        );
        $hotel_input = json_encode($hotel_input);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.altrabo.com/api/v1/HotelAvailable/Get",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 40,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $hotel_input,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: ef3adb7f-0566-4267-b6ba-9ed839d7e91f",
                "X-ZUMO-AUTH:" . $access_token,
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response)->data;

        for($i = 0; $i < count($response); $i++){

            $hotel = HotelApi::whereUserName($response[$i]->userName)->first();
            if($hotel == null){
                $newHotel = new HotelApi;
                $newHotel->name = $response[$i]->hotelName;
                $newHotel->rph = $response[$i]->rph;
                $newHotel->userName = $response[$i]->userName;
                $newHotel->facility = $response[$i]->hotelFacility;
                $newHotel->cityName = $city_name;
                $newHotel->money = $response[$i]->startPrice;

                $newHotel->save();
            }
            else{
                $hotel->money = $response[$i]->startPrice;
                $hotel->save();
            }
        }

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return true;
        }
    }
    private function getHotelInfo($hotelName, $access_token){

        $hotel_input = array('CheckIn' => '2019-02-18',
            'CheckOut' => '2019-02-20',
            'CityIdOrHotelId' => $hotelName,
            'Nationality' => 'IR',
            'Type' => 1,
            'Categorykey' => 'hotel',
            'IsDomestic' => true
        );

        $hotel_input = json_encode($hotel_input);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.altrabo.com/api/v1/HotelAvailable/GetInfo",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 40,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $hotel_input,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: 3f4ae4f0-7cf6-4a3a-a29c-598cf2d7f8ee",
                "X-ZUMO-AUTH:" . $access_token,
                "cache-control: no-cache"
            ),
        ));


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response)->data[0]->policy;
        }
    }

    public function emailtest($email)
    {
        $header = 'فراموشی رمز عبور';
        $userName = 'koochita';
        $link = 'https://kiavashzp.ir/newPass?code=dljfdlsfjlkd';
        $view = \View::make('emails.forgetPass', compact(['header', 'userName', 'link']));
        $html = $view->render();
        echo $html;
//        sendEmail($html, $header, $email);
//        dd('send to ' . $email);
    }

    public function exportExcel()
    {
//        $serverName = "localhost";
//        $username = "root";
//        $password = '';
//        $dbName = "admin_shazde";
//
//        $conn = mysqli_connect($serverName, $username, $password);
//
//        $conn->set_charset("utf8");
//        mysqli_select_db($conn, $dbName) or die("Connection failed: ");
//
//        $dbLink = $conn;
//        $start = 0;
//        $end = 50;

        $alpha = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $cols = [];
        for($i = 0; $i < count($alpha); $i++){
            if($i == 0){
                $cols = $alpha;
            }
            for($j = 0; $j < count($alpha); $j++)
                array_push($cols, $alpha[$i].''.$alpha[$j]);
        }
        $rowNum = 1;
        $places = Amaken::all()->toArray();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        for ($i = 0; $i < count($places); $i++){
            if($i == 0){
                $j = 0;
                foreach ($places[$i] as $key => $value){
                    $cell = $cols[$j].(string)$rowNum;
                    $sheet->setCellValue($cell, $key);
                    $j++;
                }
                $rowNum++;
            }
            $j = 0;
            foreach ($places[$i] as $key => $value){
                $cell = $cols[$j].(string)$rowNum;
                $sheet->setCellValue($cell, $value);
                $j++;
            }
            $rowNum++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('exportAmaken.xlsx');

        dd('finniish');
    }

    public function exporPhone()
    {
        $rowNum = 1;
        $users = User::select(['username', 'phone'])->whereNotNull('phone')->where('phone', '!=', '')->orderByDesc('created_at')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach($users as $item){
            $sheet->setCellValue("A".(string)$rowNum, $item->username);
            $sheet->setCellValue("B".(string)$rowNum, $item->phone);
            $rowNum++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('exportUsersPhone.xlsx');

        dd('finniish');
    }

}
