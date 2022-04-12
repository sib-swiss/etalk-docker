<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Talk;
use Illuminate\Http\Request;

class TalkController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'talks' => Talk::with('sounds')
                ->where('published', 1)
                ->orderBy('date', 'DESC')
                ->get(),
        ];

        return view('home', $data);
    }

    public function show(Talk $talk)
    {
        return view('talk', ['talk' => $talk]);
    }
}
