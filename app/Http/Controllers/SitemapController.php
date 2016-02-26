<?php

namespace LaraDoc\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use LaraDoc\Http\Controllers\Controller;
use Request;
use Storage;
use function config;
use function str_slug;
use function url;
use function view;

class SitemapController extends Controller
{

    /**
     * Sitemap generator
     *
     * @return xml
     */
    public function map()
    {
        $url = explode("/", Request::getUri());

        return Cache::remember(str_slug($url[2].'sitemap'), config('settings.cache', 60), function() {
                    $directories = Storage::directories('docs');
                    $resources   = [];
                    $resources[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

                    foreach ($directories as $dir) {
                        if ($dir != "docs/nbproject") {
                            $files = Storage::files($dir);

                            if (count($files) > 0) {
                                foreach ($files as $file) {
                                    $resources[] = '<url>';
                                    $resources[] = '<loc>'.url(substr($file, 0, count($file) - 4)).'</loc>';
                                    $resources[] = '<lastmod>'.date("Y-m-d", Storage::lastModified($file)).'</lastmod>';
                                    $resources[] = '<priority>'.config('settings.sitemap_priority', '0.5').'</priority>';
                                    $resources[] = '</url>';
                                }
                            }
                        }
                    }

                    $resources[] = '</urlset>';

                    return implode('', $resources);
                });
    }
}
