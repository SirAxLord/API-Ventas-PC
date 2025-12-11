<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class LandingController extends Controller
{
    public function index()
    {
        $readmePath = base_path('README.md');
        $openapiPath = base_path('docs/openapi.yaml');

        $readme = File::exists($readmePath) ? File::get($readmePath) : null;
        $hasOpenApi = File::exists($openapiPath);

        return view('landing', [
            'readme' => $readme,
            'hasOpenApi' => $hasOpenApi,
        ]);
    }
}
