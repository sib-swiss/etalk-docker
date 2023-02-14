<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSoundRequest;
use App\Http\Requests\UpdateSoundRequest;
use App\Models\Sound;
use App\Models\Talk;

class SoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSoundRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSoundRequest $request)
    {
        $talk = Talk::find($request->etalk_id);
        $file = $request->file('audioFile');
        $sound = $talk->sounds()->create([
            'name' => $talk->dir
                .'/'.$file->getClientOriginalName(),
            'text' => $request->text ?: '',
            'entities' => $request->entities ?: '',
            'file' => $request->input('file') ?: '',
            'type' => 'explanation',

        ]);
        // dd($sound->toArray());
        $storedFile = $file->storeAs(
            'public/data/'.$talk->dir,
            $file->getClientOriginalName()
        );

        return response()->json([
            'sound' => $sound->toArray(),
            'storedFile' => $storedFile,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function show(Sound $sound)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function edit(Sound $sound)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSoundRequest  $request
     * @param  \App\Models\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSoundRequest $request, Sound $sound)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sound  $sound
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sound $sound)
    {
        //
    }
}
