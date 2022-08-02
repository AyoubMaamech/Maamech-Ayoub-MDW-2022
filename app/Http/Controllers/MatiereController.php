<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Matiere();
        $data->enseignant_id = $request->enseignant;
        $data->module_id = $request->module;
        $data->nom = $request->nom;
        $data->coef = $request->coef;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Module successfully created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back()->with('matiere', Matiere::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Matiere::findOrFail($id);
        $data->enseignant_id = $request->enseignant;
        $data->module_id = $request->module;
        $data->nom = $request->nom;
        $data->coef = $request->coef;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Subject successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Matiere::destroy($id);
        session('ok', true);
        return back()->with('ok', __('Subject successfully deleted'));
    }
}
