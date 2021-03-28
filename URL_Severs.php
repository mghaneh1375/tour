<?php

namespace Illuminate\Support\Facades;

/**
 * @see \Illuminate\Routing\UrlGenerator
 */
class URL extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'url';
    }

    static function asset($path, $secure = null, $serverNum = 1) {
        $tmp = explode('/', $path);
        if(count($tmp) > 0) {
            $stub = "";
            for($i = 1; $i < count($tmp); $i++) {
                $stub .= $tmp[$i];
                if($i != count($tmp) - 1)
                    $stub .= '/';
            }

            $httpType = config('app.env') == 'local' ? "http" : "https";

            $serverNum = $serverNum == 1 ? '' : $serverNum;

            switch ($tmp[0]) {
                case "_images":
                case "defaultPic":
                case "userPhoto":
                case "userProfile":
                case "activities":
                case "ads":
                case "posts":
                case "vr2":
                    return "{$httpType}://static{$serverNum}.koochita.com/{$tmp[0]}/{$stub}";
                case "css":
                case "js":
                case "images":
                    return "{$httpType}://koochita.com/{$tmp[0]}/{$stub}";
            }
        }

        return app('url')->asset($path, $secure);
    }

    private static function cdn($key) {
//    '_image_CDN' => 'http://79.175.133.206:8080/_images/'
        $arr = ['imageCDN' => 'https://shazdemosafer.com/images/',
            '_image_CDN' => 'http://assets.baligh.ir/_images/',
            'cssCDN' => 'https://shazdemosafer.com/css/',
            'jsCDN' => 'https://shazdemosafer.com/js/',
            'fontCDN' => 'https://shazdemosafer.com/fonts/'];
        return $arr[$key];
    }
}
