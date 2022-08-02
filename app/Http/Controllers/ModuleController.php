<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Module();
        $data->nom = $request->module;
        $data->classe_id = $request->classe;
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
        return back()->with('module', Module::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Module::findOrFail($id);
        $data->nom = $request->module;
        $data->classe_id = $request->classe;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Module successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Module::where($id)->delete();
        session('ok', true);
        return back()->with('ok', __('Module successfully deleted'));
    }
}
