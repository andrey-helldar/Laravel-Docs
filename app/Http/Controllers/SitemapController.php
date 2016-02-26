<?php

namespace LaraDoc\Http\Controllers;

use Illuminate\Http\Request;
use LaraDoc\Http\Requests;
use LaraDoc\Http\Controllers\Controller;

class SitemapController extends Controller
{

    /**
     * Sitemap generator
     *
     * @return xml
     */
    public function map()
    {
        $url = explode("/", \Request::getUri());

        return Cache::remember(str_slug($url[2].'sitemap'), config('settings.cache', 60), function() {
                    $directories = \Storage::directories('docs');
                    unset($resources);

                    foreach ($directories as $dir) {
                        $files = \Storage::files($dir);

                        if (count($files) > 0) {
                            foreach ($files as $file) {
                                $resources[] = [
                                    'link'         => url(substr($file, 0, count($file) - 4)),
                                    'lastModified' => date("Y-m-d", \Storage::lastModified($file)),
                                    'priority'     => '0.5'
                                ];
                            }
                        }
                    }

                    return view('sitemap')->with('resources', json_decode(json_encode($resources), false));
                });
    }
}
