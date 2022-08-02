<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use Illuminate\Http\Request;

class SeanceController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Seance();
        $data->matiere_id = $request->matiere;
        $data->jour = $request->jour;
        $data->de = $request->de;
        $data->a = $request->a;
        $data->salle = $request->salle ?? null;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Session successfully created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back()->with('seance', Seance::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Seance::findOrFail($id);
        $data->matiere_id = $request->matiere;
        $data->jour = $request->jour;
        $data->de = $request->de;
        $data->a = $request->a;
        $data->salle = $request->salle ?? null;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Session successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Seance::destroy($id);
        session('ok', true);
        return back()->with('ok', __('Session successfully deleted'));
    }
}
