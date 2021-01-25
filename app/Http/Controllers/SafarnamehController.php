<?php

namespace App\Http\Controllers;

use App\models\BookMark;
use App\models\BookMarkReference;
use App\models\Cities;
use App\models\places\Place;
use App\models\safarnameh\Safarnameh;
use App\models\safarnameh\SafarnamehCategories;
use App\models\safarnameh\SafarnamehCategoryRelations;
use App\models\safarnameh\SafarnamehCityRelations;
use App\models\safarnameh\SafarnamehCommentLikes;
use App\models\safarnameh\SafarnamehComments;
use App\models\safarnameh\SafarnamehLike;
use App\models\safarnameh\SafarnamehPlaceRelations;
use App\models\safarnameh\SafarnamehTagRelations;
use App\models\safarnameh\SafarnamehTags;
use App\models\State;
use App\models\Tag;
use App\models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use http\Env\Response;
use Illuminate\Http\Request;

class SafarnamehController extends Controller
{

    public function safarnamehListRedirect($type, $search)
    {
        return redirect(route('safarnameh.list', ['type' => $type, 'search' => $search]));
    }
    public function storeSafarnameh(Request $request)
    {
        $user = \Auth::user();
        if($request->id == 0) {
            $newSafarnameh = new Safarnameh();
            $newSafarnameh->release = 'released';
            $newSafarnameh->userId = $user->id;
            $newSafarnameh->date = Verta::now()->format('Ymd');
            $newSafarnameh->time = Verta::now()->format('Hi');
        }
        else{
            $newSafarnameh = Safarnameh::where('id', $request->id)->where('userId', $user->id)->first();
            if($newSafarnameh == null)
                echo 'notFound';
        }
        $newSafarnameh->title = $request->title;
        $newSafarnameh->description = $request->text;
        $newSafarnameh->summery = $request->summery;
        $newSafarnameh->confirm = 0;
        $newSafarnameh->save();

        $location = __DIR__ . '/../../../../assets/_images/posts/'.$newSafarnameh->id;
        if(!file_exists($location))
            mkdir($location);

        $limboLocation = __DIR__.'/../../../../assets/_images/posts/limbo';
        $limboLoc = '_images/posts/limbo/';
        $text = $newSafarnameh->description;
        $index = strpos($text, $limboLoc);
        while($index !== false){
            $fNameIndex = strPos($text, '"', $index);
            $fName = substr($text, $index, $fNameIndex-$index);
            $lastSlash = strripos($fName, '/');
            $fileName = substr($fName, $lastSlash+1);
            $text = str_replace($fName, '_images/posts/'.$newSafarnameh->id.'/'.$fileName, $text);
            rename($limboLocation.'/'.$fileName, $location.'/'.$fileName);
            $index = strpos($text, $limboLoc);
        }
        $newSafarnameh->description = $text;
        $newSafarnameh->save();

        if($request->file('pic') != null){
            $size = [
                [
                    'width' => 1080,
                    'height' => null,
                    'name' => '',
                    'destination' => $location
                ],
            ];

            if($request->id != 0 && is_file($location.'/'.$newSafarnameh->pic))
                unlink($location.'/'.$newSafarnameh->pic);

            $image = $request->file('pic');
            $fileName = resizeImage($image, $size);
            $newSafarnameh->pic = $fileName;
            $newSafarnameh->save();
        }

        $citIds = [0];
        $plsIds = [0];
        $places = \GuzzleHttp\json_decode($request->placePick);
        foreach ($places as $place){
            if($place->kindPlaceId == 'state' || $place->kindPlaceId == 'city') {
                if($place->kindPlaceId == 'state') {
                    $stId = $place->placeId;
                    $citId = 0;
                }
                else{
                    $city = Cities::find($place->placeId);
                    $stId = $city->stateId;
                    $citId = $city->id;
                }
                $idd = SafarnamehCityRelations::where('safarnamehId', $newSafarnameh->id)
                    ->where('stateId', $stId)
                    ->where('cityId', $citId)
                    ->firstOrCreate(['safarnamehId' => $newSafarnameh->id, 'stateId' => $stId, 'cityId' => $citId]);

                array_push($citIds, $idd->id);
            }
            else{
                $idd = SafarnamehPlaceRelations::where('safarnamehId', $newSafarnameh->id)
                    ->where('kindPlaceId', $place->kindPlaceId)
                    ->where('placeId', $place->placeId)
                    ->firstOrCreate(['safarnamehId' => $newSafarnameh->id,
                                     'kindPlaceId' => $place->kindPlaceId,
                                     'placeId' => $place->placeId]);

                array_push($plsIds, $idd->id);
            }
        }

        SafarnamehPlaceRelations::where('safarnamehId', $newSafarnameh->id)
                                ->whereNotIn('id', $plsIds)->delete();
        SafarnamehCityRelations::where('safarnamehId', $newSafarnameh->id)
                                ->whereNotIn('id', $citIds)->delete();

        $tagsId = [0];
        $tags = explode(',', $request->tags);
        foreach ($tags as $tag){
            if($tag != ''){
                $checkTag = SafarnamehTags::where('tag', $tag)
                    ->firstOrCreate(['tag' => $tag]);
                $idd = SafarnamehTagRelations::where('safarnamehId', $newSafarnameh->id)
                                        ->where('tagId', $checkTag->id)
                                        ->firstOrCreate(['safarnamehId' => $newSafarnameh->id, 'tagId' => $checkTag->id]);
                array_push($tagsId, $idd->id);
            }
        }

        SafarnamehTagRelations::where('safarnamehId', $newSafarnameh->id)
                            ->whereNotIn('id', $tagsId)->delete();

        echo 'ok';
        return;
    }

    public function getSafarnameh(Request $request)
    {
        if(isset($request->id)){
            $user = auth()->user();
            $safarnameh = Safarnameh::find($request->id);
            if($safarnameh->userId == $user->id){
                $safarnameh->pic = \URL::asset('_images/posts/'.$safarnameh->id.'/'.$safarnameh->pic);
                $safarnameh->tags = SafarnamehTagRelations::join('safarnamehTags', 'safarnamehtags.id', 'safarnamehTagRelations.tagId')
                                    ->where('safarnamehTagRelations.safarnamehId', $safarnameh->id)
                                    ->select(['safarnamehtags.tag'])->pluck('safarnamehtags.tag')->toArray();
                $places = [];
                $cit = SafarnamehCityRelations::where('safarnamehId', $safarnameh->id)->get();

                foreach ($cit as $item){
                    if($item->cityId == 0){
                        $state = State::find($item->stateId);
                        array_push($places, ['kindPlaceId' => 'state', 'kindPlaceName' => '', 'placeId' => $state->id, 'name' => 'استان ' . $state->name, 'pic' => getStatePic($state->id, 0), 'state' => '']);
                    }
                    else{
                        $city = Cities::find($item->cityId);
                        $state = State::find($item->stateId);
                        array_push($places, ['kindPlaceId' => 'city', 'kindPlaceName' => '', 'placeId' => $city->id, 'name' => 'شهر ' . $city->name, 'pic' => getStatePic($state->id, $city->id), 'state' => 'در استان ' . $state->name]);
                    }
                }

                $pla = SafarnamehPlaceRelations::where('safarnamehId', $safarnameh->id)->get();
                foreach ($pla as $item){
                    $kindPlace = Place::find($item->kindPlaceId);
                    if($kindPlace != null) {
                        $place = \DB::table($kindPlace->tableName)->select(['id', 'name', 'picNumber', 'cityId'])->find($item->placeId);
                        if ($place != null) {
                            $place->pic = getPlacePic($place->id, $kindPlace->id, 'f');
                            $cit = Cities::find($place->cityId);
                            $sta = State::find($cit->stateId);
                            $stasent = 'استان ' . $sta->name . ' ، شهر' . $cit->name;
                            array_push($places, ['kindPlaceId' => $kindPlace->id,
                                'kindPlaceName' => $kindPlace->name, 'placeId' => $place->id,
                                'name' => $place->name, 'pic' => $place->pic, 'state' => $stasent]);
                        }
                    }
                }

                $safarnameh->places = $places;
                echo json_encode(['status' => 'ok', 'result' => $safarnameh]);
            }
            else
                echo json_encode(['status' => 'notForYou']);
        }
        else
            echo json_encode(['status' => 'nok']);

        return;
    }

    public function deleteSafarnameh(Request $request)
    {
        if(isset($request->id)){
            $user = \Auth::user();
            $safar = Safarnameh::find($request->id);
            if($safar->userId == $user->id){
                SafarnamehCategoryRelations::where('safarnamehId', $request->id)->delete();
                SafarnamehPlaceRelations::where('safarnamehId', $request->id)->delete();
                SafarnamehTagRelations::where('safarnamehId', $request->id)->delete();
                SafarnamehCityRelations::where('safarnamehId', $request->id)->delete();

                $location = __DIR__ .'/../../../../assets/_images/posts/'.$safar->id;
                if(is_dir($location)){
                    $files = scandir($location);
                    foreach ($files as $pic){
                        if(is_file($location.'/'.$pic))
                            unlink($location.'/'.$pic);
                    }
                    if(count(scandir($location)) == 2)
                        rmdir($location);
                }
                $safar->delete();
                echo 'ok';
            }
            else
                echo 'notForYou';
        }
        else
            echo 'nok';

        return;
    }

    public function storeSafarnamehPics(Request $request)
    {
        $user = \Auth::user();
        if( $_FILES['file'] && $_FILES['file']['error'] == 0){
            $location = __DIR__ . '/../../../../assets/_images/posts/limbo';
            if (!file_exists($location))
                mkdir($location);

            $size = [[
                        'width' => 900,
                        'height' => null,
                        'name' => $user->id.'_',
                        'destination' => $location
                    ]];

            $image = $request->file('file');
            $fileName = resizeImage($image, $size);

            echo json_encode(['url' => \URL::asset('_images/posts/limbo/'.$user->id.'_'.$fileName)]);
        }
        else
            echo false;

        return;
    }

    public function addSafarnamehBookMark(Request $request)
    {
        if(isset($request->id)){
            $kind = BookMarkReference::where('group', 'safarnameh')->first();
            $bookMark = BookMark::where('userId', auth()->user()->id)
                                  ->where('referenceId', $request->id)
                                  ->where('bookMarkReferenceId', $kind->id)
                                  ->first();
            if($bookMark == null){
                $bookMark = new BookMark();
                $bookMark->userId = auth()->user()->id;
                $bookMark->referenceId = $request->id;
                $bookMark->bookMarkReferenceId = $kind->id;
                $bookMark->save();
                return response()->json(['status' => 'store']);
            }
            else{
                $bookMark->delete();
                return response()->json(['status' => 'delete']);
            }

        }
        else
            return response()->json(['status' => 'error']);
    }

    public function safarnamehRedirect($slug)
    {
        $safarnmeh = Safarnameh::where('slug', $slug)->first();
        if($safarnmeh == null)
            return redirect(route('safarnameh.index'));
        else
            return redirect(route('safarnameh.show', ['id' => $safarnmeh->id]));
    }

    public function safarnamehMainPage() {
        return view('Safarnameh.safarnameh');
    }

    public function getSafarnamehListElements()
    {
        $page = $_GET['page'];
        $take = $_GET['take'];

        $func = getToday();
        $today = $func["date"];
        $nowTime = $func["time"];

        $allSafarnameh = Safarnameh::whereRaw('(date <= ' . $today . ' OR (date = ' . $today . ' AND (time <= ' . $nowTime . ' || time IS NULL)))')
                                    ->where('release', '!=', 'draft')
                                    ->where('confirm', 1)
                                    ->select('userId', 'id', 'title', 'meta', 'slug', 'seen', 'date', 'created_at', 'pic', 'keyword', 'release')
                                    ->orderBy('date', 'DESC')
                                    ->skip(($page-1) * $take)
                                    ->take($take)
                                    ->get();

        foreach ($allSafarnameh as $item)
            $item = SafarnamehMinimalData($item);

        return response()->json(['status' => 'ok', 'result' => $allSafarnameh]);
    }

    public function safarnamehMainPageData()
    {
        $timeFunc = getToday();
        $today = $timeFunc["date"];
        $todayTime = $timeFunc["time"];

        $lastMonthDate = \verta(Carbon::now()->subMonth())->format('Y/m/%d');
        $lastMonthDate = convertDateToString($lastMonthDate);

        if(isset($_GET['banner']) && $_GET['banner'] == 1){

            $bSafarnameh = \DB::table('safarnameh')
                ->join('bannerPosts', 'postId', 'safarnameh.id')
                ->where('date', '<=', $today)
                ->select(['userId', 'safarnameh.id', 'safarnameh.title',
                    'safarnameh.seen', 'safarnameh.created_at', 'safarnameh.pic',
                    'safarnameh.date', 'safarnameh.title', 'safarnameh.keyword',
                    'safarnameh.slug', 'safarnameh.summery', 'safarnameh.meta'])
                ->get();

            if(count($bSafarnameh) == 3)
                $countBanner = 2;
            else if(count($bSafarnameh) > 5)
                $countBanner = 5;
            else
                $countBanner = count($bSafarnameh);

            $bannerPosts = [];
            for($i = 0; $i < $countBanner; $i++)
                array_push($bannerPosts, SafarnamehMinimalData($bSafarnameh[$i]));

            $time = microtime(true) - LARAVEL_START;
            return response()->json(['status' => 'ok', 'bannerPosts' => $bannerPosts, 'time' => $time]);
        }
        else if(isset($_GET['other']) &&$_GET['other'] == 1){
            //this section get all safarnameh released in last month
            $lastMonthSafarnameh = [];
            $lastMonthSafarnamehId = [];
            $lms = \DB::select('SELECT safarnameh.id, safarnameh.title, safarnameh.summery, safarnameh.meta, safarnameh.slug, `date`, safarnameh.time, safarnameh.keyword, safarnameh.pic, safarnameh.seen, safarnameh.userId, u.username AS username FROM safarnameh LEFT JOIN `users` AS u ON safarnameh.userId = u.id WHERE (`date` > ' . $lastMonthDate . ' OR (safarnameh.date = ' . $lastMonthDate . ' AND safarnameh.time <= ' . $todayTime . ' )) AND safarnameh.release <> "draft" AND safarnameh.confirm = 1 ORDER By safarnameh.date DESC ');
            foreach ($lms as $item) {
                $item = SafarnamehMinimalData($item);
                array_push($lastMonthSafarnameh, $item);
                array_push($lastMonthSafarnamehId, $item->id);
            }

            if(count($lastMonthSafarnamehId) < 10){
                $take = 10 - count($lastMonthSafarnamehId);
                $lms2 = Safarnameh::whereNotIn('id', $lastMonthSafarnamehId)
                    ->where('release', '!=', 'draft')
                    ->where('confirm', 1)
                    ->orderByDesc('date')
                    ->take($take)
                    ->get();
                foreach ($lms2 as $item) {
                    $item = SafarnamehMinimalData($item);
                    array_push($lastMonthSafarnameh, $item);
                    array_push($lastMonthSafarnamehId, $item->id);
                }
            }
            // end get lastMonthSafarnameh

            //this section get 5 most like post from lastMonthSafarnameh
            $likePost = [];
            if(count($lastMonthSafarnamehId) > 0)
                $likePost = \DB::select('SELECT safarnameh.id, COUNT(safarnamehLike.id) as likeCount FROM safarnameh JOIN safarnamehLike ON safarnamehLike.like = 1 AND safarnamehLike.safarnamehId = safarnameh.id AND safarnameh.id IN (' . implode(",", $lastMonthSafarnamehId) . ')  GROUP BY safarnameh.id ORDER BY likeCount DESC');

            $mostLike = array();
            $mostLikeId = array();
            foreach ($likePost as $item){
                foreach ($lastMonthSafarnameh as $item2){
                    if($item->id == $item2->id){
                        $item2->likes = $item->likeCount;
                        array_push($mostLike, $item2);
                        array_push($mostLikeId, $item->id);
                        break;
                    }
                }
            }
            foreach ($lastMonthSafarnameh as $item){
                if(!in_array($item->id, $mostLikeId) && count($mostLikeId) < 5){
                    array_push($mostLike, $item);
                    array_push($mostLikeId, $item->id);
                }
            }
            // end mostLikePost

            //this section get mostSeen Post from lastMonthSafarnameh
            $mostSeenSafarnameh = array();
            for($i = 0; $i < count($lastMonthSafarnameh); $i++){
                for($j = $i + 1; $j < count($lastMonthSafarnameh); $j++){
                    if($lastMonthSafarnameh[$i]->seen < $lastMonthSafarnameh[$j]->seen){
                        $c = $lastMonthSafarnameh[$i];
                        $lastMonthSafarnameh[$i] = $lastMonthSafarnameh[$j];
                        $lastMonthSafarnameh[$j] = $c;
                    }
                }
            }
            for($i = 0; $i < 5 && $i < count($lastMonthSafarnameh); $i++)
                array_push($mostSeenSafarnameh, $lastMonthSafarnameh[$i]);
            //end mostSeen Post

            //this section get mostComment Post from lastMonthSafarnameh
            $commentPost = [];
            if(count($lastMonthSafarnamehId) > 0)
                $commentPost = \DB::select('SELECT safarnameh.id, COUNT(safarnamehComment.id) as CommentCount FROM safarnameh JOIN safarnamehComment ON safarnamehComment.confirm = 1 AND safarnamehComment.safarnamehId = safarnameh.id AND safarnameh.id IN (' . implode(",", $lastMonthSafarnamehId) . ')  GROUP BY safarnameh.id ORDER BY CommentCount DESC');
            $mostCommentSafarnameh = [];
            $mostCommentSafarnamehId = [];
            foreach ($commentPost as $item){
                foreach ($lastMonthSafarnameh as $item2){
                    if($item->id == $item2->id){
                        $item2->msgs = $item->CommentCount;
                        array_push($mostCommentSafarnameh, $item2);
                        array_push($mostCommentSafarnamehId, $item->id);
                        break;
                    }
                }
            }
            foreach ($lastMonthSafarnameh as $item){
                if(!in_array($item->id, $mostCommentSafarnamehId) && count($mostCommentSafarnamehId) < 5){
                    array_push($mostCommentSafarnameh, $item);
                    array_push($mostCommentSafarnamehId, $item->id);
                }
            }
            //end mostComment Post

            $time = microtime(true) - LARAVEL_START;
            return response()->json(['status' => 'ok', 'mostLike' => $mostLike, 'mostCommentSafarnameh' => $mostCommentSafarnameh,
                                     'mostSeenSafarnameh' => $mostSeenSafarnameh, 'time' => $time]);
        }
    }

    public function safarnamehList($type = '',$search = '')
    {
        $today = getToday()['date'];
        $nowTime = getToday()['time'];
        $headerList = '';

        if($search != ''){
            $safarnameh = [];

            if($type == 'content' || $type == 'category') {
                $safarnamehContentId = [0];
                if ($type == 'content') {
                    $tagRelId = SafarnamehTags::join('safarnamehTagRelations', 'safarnamehTagRelations.id', 'safarnamehTags.id')
                                            ->where('safarnamehTags.tag', 'LIKE', '%' . $search . '%')
                                            ->groupBy('safarnamehTagRelations.safarnamehId')
                                            ->pluck('safarnamehTagRelations.safarnamehId')
                                            ->toArray();

                    $safarnamehContentId = Safarnameh::whereRaw('(safarnameh.date < ' . $today . ' OR (safarnameh.date = ' . $today . ' AND  (safarnameh.time <= ' . $nowTime . ' OR safarnameh.time IS NULL)))')
                                            ->whereRaw('(safarnameh.title LIKE "%' . $search . '%" OR safarnameh.slug LIKE "%' . $search . '%" OR safarnameh.keyword LIKE "%' . $search . '%")')
                                            ->orWhereIn('safarnameh.id', $tagRelId)
                                            ->whereRaw('safarnameh.release <> "draft"')
                                            ->pluck('id')
                                            ->toArray();
                    if(count($safarnamehContentId) == 0)
                        $safarnamehContentId = [0];
                }
                $categ = SafarnamehCategories::where('name', $search)
                                            ->pluck('id')
                                            ->toArray();
                $safarnamehCatId = SafarnamehCategoryRelations::whereIn('categoryId', $categ)
                                            ->pluck('safarnamehId')
                                            ->toArray();

                $safarnameh = Safarnameh::whereIn('safarnameh.id', $safarnamehCatId)
                                        ->orWhereIn('safarnameh.id', $safarnamehContentId)
                                        ->whereRaw('(safarnameh.date < ' . $today . ' OR (safarnameh.date = ' . $today . ' AND  (safarnameh.time <= ' . $nowTime . ' OR safarnameh.time IS NULL)))')
                                        ->whereRaw('safarnameh.release <> "draft"')
                                        ->count();


                if($type == 'category')
                    $headerList = 'دسته ' . SafarnamehCategories::where('name', $search)->first()->name;
                else
                    $headerList = 'عبارت #' . $search;
            }
            else{
                if($type == 'place'){
                    $s = explode('_', $search);
                    $kindPlaceId = $s[0];
                    $placeId = $s[1];
                    $safarnamehId = SafarnamehPlaceRelations::where('kindPlaceId', $kindPlaceId)
                                                            ->where('safarnamehId', $placeId)
                                                            ->pluck('safarnamehId')
                                                            ->toArray();
                    $headerList = 'عبارت #' . $search;
                }
                else if($type == 'state') {
                    $place = State::whereName($search)->first();
                    if($place == null)
                        return redirect(route('safarnameh.list', ['type' => 'content', 'search' => $search]));

                    $safarnamehId = SafarnamehCityRelations::where('stateId', $place->id)->pluck('safarnamehId')->toArray();
                    $headerList = 'استان ' . $search;
                    $search = $place->id;
                }
                else{
                    if($search == 'ایران من')
                        return redirect(route('safarnameh.index'));

                    $place = Cities::whereName($search)->first();
                    if($place == null)
                        return redirect(route('safarnameh.list', ['type' => 'content', 'search' => $search]));

                    $safarnamehId = SafarnamehCityRelations::where('cityId', $place->id)->pluck('safarnamehId')->toArray();
                    $headerList = 'شهر ' . $search;
                    $search = $place->id;
                }

                $safarnameh = Safarnameh::whereIn('id', $safarnamehId)
                                        ->where('confirm', 1)
                                        ->where('release', '!=', 'draft')
                                        ->whereRaw('(date < ' . $today . ' OR (date = ' . $today . ' AND  (time <= ' . $nowTime . ' OR time IS NULL)))')
                                        ->count();
            }

            $pageLimit = ceil($safarnameh / 5);
            return \view('Safarnameh.safarnamehList', compact(['pageLimit', 'type', 'search', 'headerList']));
        }

        return \redirect(\route('safarnameh.index'));
    }

    public function paginationInSafarnamehList(Request $request){

        if(isset($_GET['type']) && isset($_GET['search']) && isset($_GET['take']) && isset($_GET['page']) && $_GET['search'] != ''){
            $type = $_GET['type'];
            $search = $_GET['search'];
            $take = $_GET['take'];
            $page = $_GET['page'];

            $Tfunc = getToday();
            $today = $Tfunc['date'];
            $nowTime = $Tfunc['time'];
            $safaranmeh = [];
            $safarnamehId = [0];

            if($search != ''){
                if($type == 'content' || $type == 'category'){
                    if($type == 'content'){
                        $tagRelId = SafarnamehTagRelations::join('safarnamehTags', 'safarnamehTags.id', 'safarnamehTagRelations.tagId')
                                                            ->where('safarnamehTags.tag', 'LIKE', '%'. $search .'%')
                                                            ->pluck('safarnamehTagRelations.safarnamehId')
                                                            ->toArray();

                        $safarnamehId = Safarnameh::whereRaw('(title LIKE "%' . $search . '%" OR slug LIKE "%' . $search . '%" OR keyword LIKE "%' . $search . '%")')
                                                    ->orWhereIn('id', $tagRelId)
                                                    ->where('release', '!=', 'draft')
                                                    ->pluck('id')
                                                    ->toArray();

                        $safarnamehId = array_merge($safarnamehId, $tagRelId);
                    }
                    $cateId = [0];
                    $category = SafarnamehCategories::where('name', $search)->first();
                    if($category != null){
                        if($category->parent == 0)
                            $cateId = SafarnamehCategories::where('id', $category->id)
                                        ->orWhere('parent', $category->id)
                                        ->pluck('id')
                                        ->toArray();
                        else
                            $cateId = [$category->id];
                    }

                    $safarnamehId2 = SafarnamehCategoryRelations::whereIn('categoryId', $cateId)
                                        ->pluck('safarnamehId')
                                        ->toArray();

                    $safarnamehId = array_merge($safarnamehId, $safarnamehId2);

                    $safaranmeh = Safarnameh::WhereIn('id', $safarnamehId)
                                            ->where('confirm', 1)
                                            ->where('release', '!=', 'draft')
                                            ->whereRaw('(date < ' . $today . ' OR (date = ' . $today . ' AND  (time <= ' . $nowTime . ' OR time IS NULL) ))')
                                            ->select('userId', 'id', 'title', 'meta', 'slug', 'seen', 'date', 'created_at', 'pic', 'keyword')
                                            ->orderBy('date', 'DESC')
                                            ->skip(($page-1) * $take)
                                            ->take($take)
                                            ->get();
                }
                else{
                    if($type == 'place'){
                        $s = explode('_', $search);
                        $kindPlaceId = $s[0];
                        $placeId = $s[1];
                        $safarnamehId = SafarnamehPlaceRelations::where('kindPlaceId', $kindPlaceId)
                                                                ->where('placeId', $placeId)
                                                                ->pluck('safarnamehId')
                                                                ->toArray();
                    }
                    else if($type == 'city'){
                        $place = Cities::find($search);
                        $safarnamehId = SafarnamehCityRelations::where('cityId', $place->id)
                                                            ->pluck('safarnamehId')
                                                            ->toArray();
                    }
                    else{
                        $place = State::find($search);
                        $safarnamehId = SafarnamehCityRelations::where('stateId', $place->id)
                                                            ->pluck('safarnamehId')
                                                            ->toArray();
                    }

                    $safaranmeh = [];
                    if(count($safarnamehId) != 0) {
                        $safaranmeh = Safarnameh::whereIn('id', $safarnamehId)
                                                ->where('confirm', 1)
                                                ->where('release', '!=', 'draft')
                                                ->whereRaw('(date < ' . $today . ' OR (date = ' . $today . ' AND (time <= ' . $nowTime . ' OR time IS NULL) ))')
                                                ->select([  'userId', 'id', 'title', 'meta',
                                                            'slug', 'seen', 'date', 'created_at',
                                                            'pic', 'keyword'])
                                                ->orderBy('date', 'DESC')
                                                ->skip(($page - 1) * $take)
                                                ->take($take)
                                                ->get();
                    }
                }

                foreach ($safaranmeh as $item)
                    $item = SafarnamehMinimalData($item);

                return response()->json(['status' => 'ok', 'result' => $safaranmeh]);
            }
            else
                return response()->json(['status' => 'error2']);
        }
        else
            return response()->json(['status' => 'error1']);
    }

    public function showSafarnameh($id)
    {
        $safarnameh = Safarnameh::find($id);
        if($safarnameh == null)
            return \redirect()->back();

        if($safarnameh->confirm == 0){
            if(!(auth()->check() && auth()->user()->id == $safarnameh->userId))
                return \redirect()->back();
        }
        $value = 'safarnamehId:'.$safarnameh->id;
        if(!(\Cookie::has($value) == $value)) {
            $safarnameh->seen++;
            $safarnameh->save();
            \Cookie::queue(\Cookie::make($value, $value, 5));
        }


        $safarnameh = SafarnamehMinimalData($safarnameh);
        $safarnameh->youLike = 0;
        $safarnameh->bookMark = false;
        if(auth()->check()){
            $youLike = SafarnamehLike::where('safarnamehId', $safarnameh->id)
                                        ->where('userId', auth()->user()->id)
                                        ->first();
            $safarnameh->youLike = $youLike == null ? 0 : $youLike->like;
            $bookMarkKind = BookMarkReference::where('group', 'safarnameh')->first();
            $bookMark = BookMark::where('userId', auth()->user()->id)
                                ->where('referenceId', $safarnameh->id)
                                ->where('bookMarkReferenceId', $bookMarkKind->id)->first();

            if($bookMark != null)
                $safarnameh->bookMark = true;
        }

        $safarnameh->user = User::select(['id', 'username', 'introduction'])->find($safarnameh->userId);
        $safarnameh->user->pic = getUserPic($safarnameh->user->id);
        $safarnameh->tag = SafarnamehTagRelations::join('safarnamehTags', 'safarnamehTags.id', 'safarnamehTagRelations.tagId')
                                ->where('safarnamehTagRelations.safarnamehId', $safarnameh->id)
                                ->pluck('safarnamehTags.tag')
                                ->toArray();
        $similarSafarnameh = [];
        $similarSafarnamehId = SafarnamehCategoryRelations::join('safarnameh', 'safarnameh.id', 'safarnamehCategoryRelations.safarnamehId')
                                                            ->where('safarnamehCategoryRelations.categoryId', $safarnameh->categoryId)
                                                            ->where('safarnameh.id', '!=', $safarnameh->id)
                                                            ->orderByDesc('safarnameh.date')
                                                            ->take(2)->pluck('safarnamehId')->toArray();
        if(count($similarSafarnamehId)){
            $similarSafarnameh = Safarnameh::whereIn('id', $similarSafarnamehId)->get();
            foreach ($similarSafarnameh as $sim)
                $sim = SafarnamehMinimalData($sim);
        }

        $uPic = getUserPic(\auth()->check() ? \auth()->user()->id : 0);

        $localStorageData = [
            'kind' => 'place', 'name' => $safarnameh->title,
            'city' => '', 'state' => '',
            'mainPic' => $safarnameh->pic,
            'redirect' => $safarnameh->url
        ];

        $safarnameh->description = str_replace('&nbsp;', ' ', $safarnameh->description);

        return view('Safarnameh.safarnamehShow', compact(['safarnameh', 'uPic', 'localStorageData', 'similarSafarnameh']));
    }

    public function getSafarnamehComments(Request $request)
    {
        $safarnameh = Safarnameh::find($request->id);
        $comments = SafarnamehComments::where('safarnamehId', $safarnameh->id)
            ->where(function($query){
                if(auth()->check())
                    $query->where('confirm', 1)->orWhere('userId', auth()->user()->id);
                else
                    $query->where('confirm', 1);
            })
            ->where('ansTo', 0)
            ->orderByDesc('created_at')
            ->get();
        foreach ($comments as $comment) {
            $uComment = User::find($comment->userId);

            $comment->like = SafarnamehCommentLikes::where('commentId', $comment->id)->where('like', 1)->count();
            $comment->disLike = SafarnamehCommentLikes::where('commentId', $comment->id)->where('like', -1)->count();
            $comment->youLike = 0;
            if(auth()->check()) {
                $youLike = SafarnamehCommentLikes::where('commentId', $comment->id)
                    ->where('userId', auth()->user()->id)
                    ->first();
                if($youLike != null)
                    $comment->youLike = $youLike->like;
            }
            $comment->answers = $this->getAnsToComments($comment->id);
            $comment->userName = $uComment->username;
            $comment->writerPic = getUserPic($uComment->id);
            $comment->timeAgo = convertJalaliToText(\verta($comment->created_at)->format('Ym%d'));
            $comment->answersCount = count($comment->answers);
        }

        return $comments;
    }

    public function LikeSafarnameh(Request $request)
    {
        if(!\auth()->check()){
            echo json_encode(['status' => 'auth']);
            return;
        }

        if(isset($request->id) && isset($request->like)){
            $id = $request->id;
            $like = $request->like;
            $safarnameh = Safarnameh::find($id);
            if($safarnameh != null){
                $safarnamehLike = SafarnamehLike::where('userId', \auth()->user()->id)
                                                ->where('safarnamehId', $id)
                                                ->first();
                if($safarnamehLike == null)
                    $safarnamehLike = new SafarnamehLike();

                $safarnamehLike->safarnamehId = $id;
                $safarnamehLike->userId = \auth()->user()->id;
                $safarnamehLike->like = $like;
                $safarnamehLike->save();

                $like = SafarnamehLike::where('safarnamehId', $id)->where('like', 1)->count();
                $disLike = SafarnamehLike::where('safarnamehId', $id)->where('like', -1)->count();

                echo json_encode(['status' => 'ok', 'like' => $like, 'disLike' => $disLike]);
            }
            else
                echo json_encode(['status' => 'nok2']);
        }
        else
            echo json_encode(['status' => 'nok1']);

        return;
    }

    public function StoreSafarnamehComment(Request $request)
    {
        if(\auth()->check()){
            if(isset($request->id) && isset($request->txt)){
                $safarnameh = Safarnameh::find($request->id);
                if($safarnameh != null){
                    $ansTo = 0;
                    if($request->ansTo != 0){
                        $ans = SafarnamehComments::find($request->ansTo);
                        if($ans != null) {
                            $ansTo = $ans->id;
                            $ans->haveAns = 1;
                            $ans->save();
                        }
                    }

                    $comment = new SafarnamehComments();
                    $comment->safarnamehId = $safarnameh->id;
                    $comment->text = $request->txt;
                    $comment->userId = \auth()->user()->id;
                    $comment->ansTo = $ansTo;
                    $comment->confirm = 0;
                    $comment->save();

                    echo 'ok';
                }
                else
                    echo 'nok2';
            }
            else
                echo 'nok1';
        }
        else
            echo 'authError';

        return;
    }

    public function likeSafarnamehComment(Request $request)
    {
        if(\auth()->check()){
            $comment = SafarnamehComments::find($request->id);
            if($comment != null){
                $commentLike = SafarnamehCommentLikes::where('commentId', $request->id)
                                                    ->where('userId', \auth()->user()->id)
                                                    ->first();
                if($commentLike == null) {
                    $commentLike = new SafarnamehCommentLikes();
                    $commentLike->userId = \auth()->user()->id;
                    $commentLike->commentId = $request->id;
                }

                $commentLike->like = $request->like;
                $commentLike->save();

                $likeCount = \DB::select('SELECT SUM(CASE WHEN `like` = 1 THEN 1 ELSE 0 END) as likeCount, SUM(CASE WHEN `like` = -1 THEN 1 ELSE 0 END) as disLikeCount FROM safarnamehCommentLikes WHERE commentId = ' . $request->id);
                echo json_encode(['status' => 'ok', 'result' => $likeCount]);
            }
            else
                echo json_encode(['status' => 'nok1']);
        }
        else
            echo json_encode(['status' => 'authError']);

        return;
    }


    private function getAnsToComments($id){
        $ans = [];
        $comment = SafarnamehComments::find($id);
        if($comment != null && $comment->haveAns != 0){
            $ans = SafarnamehComments::where('ansTo', $comment->id)
                                        ->where(function($query){
                                            if(auth()->check())
                                                $query->where('confirm', 1)->orWhere('userId', auth()->user()->id);
                                            else
                                                $query->where('confirm', 1);
                                        })
                                        ->orderByDesc('created_at')
                                        ->get();
            foreach ($ans as $item){
                $writer = User::find($item->userId);

                $item->userName = $writer->username;
                $item->writerPic = getUserPic($writer->id);
                $item->like = SafarnamehCommentLikes::where('commentId', $item->id)->where('like', 1)->count();
                $item->disLike = SafarnamehCommentLikes::where('commentId', $item->id)->where('like', -1)->count();
                $item->youLike = 0;

                if(auth()->check()) {
                    $youLike = SafarnamehCommentLikes::where('commentId', $item->id)
                                                        ->where('userId', auth()->user()->id)
                                                        ->first();
                    if($youLike != null)
                        $item->youLike = $youLike->like;
                }
                $item->answers = $this->getAnsToComments($item->id);
                $item->answersCount = count($item->answers);
            }
        }
        return $ans;
    }

}
