<?php

namespace LaraDoc\Http\Controllers;

use Illuminate\Http\Request;
use LaraDoc\Http\Requests;
use LaraDoc\Http\Controllers\Controller;
use GrahamCampbell\Markdown\Facades\Markdown;

class DocsController extends Controller {

    public function page($version = null, $page = "installation") {
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
//        $content = \Cache::remember(str_slug($filename), config('settings.cache'), function() use ($filename) {
//                    return Markdown::convertToHtml(\Storage::get($filename));
//                });
        $content = str_replace("{{version}}", $version, \Storage::get($filename));
        $content = Markdown::convertToHtml($content);

//        return $content;
        return view('doc')
                        ->with('content', $content)
                        ->with('version', $version)
                        ->with('year', date("Y") == "2016" ? "2016" : "2016-" . date("Y"));
    }

}
