<?php

namespace App\Http\Controllers;

use App\Models\TypeEpreuve;
use Illuminate\Http\Request;

class TypeEpreuveController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new TypeEpreuve();
        $data->nom = $request->type;
        $data->coeff = $request->coeff;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Exam Type successfully created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Epreuve  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back()->with('type', TypeEpreuve::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = TypeEpreuve::findOrFail($id);
        $data->nom = $request->type;
        $data->coeff = $request->coeff;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Exam Type successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TypeEpreuve::destroy($id);
        session('ok', true);
        return back()->with('ok', __('Exam Type successfully deleted'));
    }
}
