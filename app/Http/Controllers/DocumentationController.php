<?php

namespace App\Http\Controllers;

use Parsedown;

class DocumentationController extends Controller
{
    /**
     * Parse and display markdown documentation for a given version.
     *
     * @param  string $version For example 'v1'
     * @return Illuminate\Http\Response
     */
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
