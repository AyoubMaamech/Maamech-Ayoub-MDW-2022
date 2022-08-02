<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('classes')->with('filieres', Filiere::all())->with('classes',  Classe::whereNotNull('annee')->whereNotNull('nom')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Classe();
        $data->filiere_id = $request->filiere;
        $data->niveau = $request->niveau;
        $data->annee = $request->annee;
        $data->nom = $request->nom;
        $data->save();

        session('ok', true);
        return redirect()->route('classes.index')->with('ok', __('Class successfully created'));
    }
    
    /**
     * Display a filtered listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $list = Classe::whereNotNull('annee')->whereNotNull('nom')
            ->where('id'   , 'like', '%'.($request->id ?? '').'%')
            ->where('annee', 'like', '%'.($request->annee ?? '').'%')
            ->where('nom', 'like', '%'.($request->nom ?? '').'%')->get();
        return view('classes')->with('classes', $list)->with('filieres', Filiere::all());
    }

    public static function findDefaultClasseFor($id)
    {
        return Classe::where('filiere_id', $id)->whereNull('annee')->whereNull('nom')->first()->id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('classes')->with('filieres', Filiere::all())->with('classes',  Classe::whereNotNull('annee')->whereNotNull('nom')->get())->with('classe', Classe::findOrFail($id));
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
        $data = Classe::findOrFail($id);
        $data->filiere_id = $request->filiere;
        $data->niveau = $request->niveau;
        $data->nom = $request->nom;
        $data->annee = $request->annee;
        $data->save();
        session('ok', true);
        return redirect()->route('classes.index')->with('ok', __('Class successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Classe::where('id', $id)->delete();
        session('ok', true);
        return redirect()->route('classes.index')->with('ok', __('Class successfully deleted'));
    }
}
