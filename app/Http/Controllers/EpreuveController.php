<?php

namespace App\Http\Controllers;

use App\Models\Epreuve;
use Illuminate\Http\Request;

class EpreuveController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Epreuve();
        $data->type_epreuve_id = $request->type;
        $data->matiere_id = $request->matiere;
        $data->date_epreuve = $request->date;
        $data->salle = $request->salle ?? null;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Exam successfully created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Epreuve  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back()->with('epreuve', Epreuve::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Epreuve::findOrFail($id);
        $data->type_epreuve_id = $request->type;
        $data->matiere_id = $request->matiere;
        $data->date_epreuve = $request->date;
        $data->salle = $request->salle ?? null;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Exam successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Epreuve::destroy($id);
        session('ok', true);
        return back()->with('ok', __('Exam successfully deleted'));
    }
}
