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

        Header('Content-type: text/xml');
        print(Cache::remember(str_slug($url[2].'sitemap'), config('settings.cache', 60), function() {
                    $directories = Storage::directories('docs');
                    $xml         = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');

                    foreach ($directories as $dir) {
                        if ($dir != "docs/nbproject") {
                            $files = Storage::files($dir);

                            if (count($files) > 0) {
                                foreach ($files as $file) {
                                    $resource = $xml->addChild('url');
                                    $resource->addChild('loc', url(substr($file, 0, count($file) - 4)));
                                    $resource->addChild('lastmod', date("Y-m-d", Storage::lastModified($file)));
                                    $resource->addChild('changefreq', 'daily');
                                    $resource->addChild('priority', config('settings.sitemap_priority', '0.8'));
                                }
                            }
                        }
                    }

                    return $xml->asXML();
                }));
    }
}
