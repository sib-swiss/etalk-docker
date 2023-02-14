<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function introduction(Request $request)
    {
        return view('introduction');
    }

    public function demploi(Request $request)
    {
        return view('demploi');
    }

    public function demploifr(Request $request)
    {
        return view('demploifr');
    }

    public function contact(Request $request)
    {
        return view('contact');
    }

    public function about(Request $request)
    {
        return view('about');
    }
}
