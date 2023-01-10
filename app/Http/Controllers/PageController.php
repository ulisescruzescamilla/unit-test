<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repository;

class PageController extends Controller
{
    public function home()
    {
        $repositories = Repository::latest()->get();
        return view('welcome', compact('repositories'));
    }
}
