<?php

namespace App\Http\Controllers;

use Parsedown;

class DocumentationController extends Controller
{
    public function index($version)
    {
        $docPath = doc_path($version.'.md');

        if (! is_readable($docPath)) {
            abort(404);
        }
        $parsedown = new Parsedown();

        return view('documentation.index', [
            'documentation' => $parsedown->text(file_get_contents($docPath)),
        ]);
    }
}
