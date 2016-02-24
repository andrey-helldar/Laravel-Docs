<?php

namespace LaraDoc\Http\Controllers;

use Illuminate\Http\Request;
use LaraDoc\Http\Requests;
use LaraDoc\Http\Controllers\Controller;
use GrahamCampbell\Markdown\Facades\Markdown;

class DocsController extends Controller
{

    public function page($version = null, $page = "installation")
    {
        // Check nulled params
        if (is_null($version)) {
            $version = config('settings.version', '5.2');
        }

        // Check exiting folder with translations
        if (!\Storage::exists(sprintf("docs/%s", $version))) {
            return redirect()->route('docs', ['version' => config('settings.version', '5.2')]);
        }

        // Check exiting file with translation
        if (!\Storage::exists(sprintf("docs/%s/%s.md", $version, $page))) {
            return redirect()->route('docs', ['version' => config('settings.version', '5.2')]);
        }

        // Reading file
        $content = \Storage::get(sprintf("docs/%s/%s.md", $version, $page));

//        return $content;
        return view('doc')->with('content', Markdown::convertToHtml($content));
    }
}
