<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Note();
        $data->epreuve_id = $request->epreuve;
        $data->etudiant_id = $request->etudiant;
        $data->note = $request->note;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Grade successfully created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back()->with('note', Note::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Note::findOrFail($id);
        $data->epreuve_id = $request->epreuve;
        $data->etudiant_id = $request->etudiant;
        $data->note = $request->note;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Grade successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Note::destroy($id);
        session('ok', true);
        return back()->with('ok', __('Grade successfully deleted'));
    }
}
