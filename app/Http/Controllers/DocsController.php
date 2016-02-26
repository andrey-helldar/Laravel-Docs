<?php

namespace LaraDoc\Http\Controllers;

use Illuminate\Http\Request;
use LaraDoc\Http\Requests;
use LaraDoc\Http\Controllers\Controller;
use GrahamCampbell\Markdown\Facades\Markdown;

class DocsController extends Controller {

    /**
     * Show general page
     *
     * @param string $version
     * @param string $page
     * @return string
     */
    public function page($version = null, $page = "installation") {
        // Redirect to correct domain
//        $url = explode("/", \Request::getUri());
//        if ($url[2] != "laravel-doc.ru" && $url[2] != "docs.local") {
//            $url[2] = "laravel-doc.ru";
//            $url = implode('/', $url);
//            return redirect()->away($url);
//        }

        // Check nulled params
        if (is_null($version)) {
            $version = config('settings.version', '5.2');
        }

        // Check exiting folder with translations
        if (!\Storage::exists(sprintf("docs/%s", $version))) {
            return redirect()->route('docs', ['version' => config('settings.version', '5.2')]);
        }

        $filename = sprintf("docs/%s/%s.md", $version, str_slug($page));

        // Check exiting file with translation
        if (!\Storage::exists($filename)) {
            return redirect()->route('docs', ['version' => config('settings.version', '5.2')]);
        }

        // Reading file
        $content = \Cache::remember(str_slug($filename), config('settings.cache', 60), function() use ($filename, $version) {
                    $content = str_replace("{{version}}", $version, \Storage::get($filename));
                    return Markdown::convertToHtml($content);
                });

        // Return result
        return view('doc')
                        ->with('content', $content)
                        ->with('navbarTop', $this->topmenu($version));
    }

    /**
     * Get directories names for show top menu
     *
     * @param string $version
     * @return string
     */
    private function topmenu($version = null) {
        if (is_null($version)) {
            $version = config('settings.version', '5.2');
        }

        $directories = \Cache::remember("topmenu", config('settings.cache', 60), function() use ($version) {
                    $directories = str_replace('docs/', '', \Storage::directories('docs'));
                    arsort($directories);

                    // Check exists of "installation.md"
                    foreach ($directories as $key => $dir) {
                        if (!\Storage::exists(sprintf("docs/%s/installation.md", $dir))) {
                            unset($directories[$key]);
                        }
                    }

                    return $directories;
                });

        return view('navbars.top')
                        ->with('version', $version)
                        ->with('directories', $directories);
    }

}
