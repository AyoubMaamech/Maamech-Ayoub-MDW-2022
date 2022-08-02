<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('classes')->with('filieres', Filiere::all())->with('classes',  Classe::whereNotNull('annee')->whereNotNull('niveau')->whereNotNull('nom')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Filiere();
        $data->nom = $request->filiere;
        $data->save();

        $defaultClasse = new Classe();
        $defaultClasse->annee = null;
        $defaultClasse->niveau = null;
        $defaultClasse->nom = null;
        $defaultClasse->filiere_id = $data->id;
        $defaultClasse->save();

        session('ok', true);
        return redirect()->route('filieres.index')->with('ok', __('Course successfully created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('classes')->with('filieres', Filiere::all())->with('classes',  Classe::whereNotNull('annee')->whereNotNull('niveau')->whereNotNull('nom')->get())->with('filiere', Filiere::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Filiere::findOrFail($id);
        $data->nom = $request->filiere;
        $data->save();
        session('ok', true);
        return redirect()->route('filieres.index')->with('ok', __('Course successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Filiere::where('id', $id)->delete();
        session('ok', true);
        return redirect()->route('filieres.index')->with('ok', __('Course successfully deleted'));
    }
}
