<?php

namespace App\Http\Controllers;

use App\Models\Page;

abstract class Controller
{
    protected function getPage($slug): Page
    {
        $page = Page::where('slug', $slug)->with('media')->firstOrFail();
        return $page;
    }
}
