<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Repositories\MatiereRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->profile === 'student')
            return view('teachers.index')->with('teachers', MatiereRepository::getEnseignantsPourEtudiant(auth()->user()->etudiant->id));
        if (auth()->user()->profile === 'parent')
            return view('teachers.index')->with('teachers', MatiereRepository::getEnseignantsPourParent(auth()->user()->parent->id));
        return view('teachers.index')->with('teachers', Enseignant::all());
    }
    
    /**
     * Display a filtered listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $list = Enseignant::where('cin', 'like', '%'.($request->cin ?? '').'%')
            ->where(DB::raw('CONCAT(prenom, nom)'), 'like', '%'.($request->nom ?? '').'%')
            ->where('titre', 'like', '%'.($request->titre ?? '').'%')->get();
        return view('teachers.index')->with('teachers', $list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = ProfileController::readForm($request, 'teacher');
        session('ok', true);
        return redirect()->route('enseignants.index')->with('ok', __('Teacher successfully created'))->with('teachers', Enseignant::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enseignant  $enseignant
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return view('teachers.details')->with('teacher', Enseignant::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('teachers.form')->with('edit', true)->with('teacher', Enseignant::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enseignant  $enseignant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = ProfileController::readForm($request, 'teacher', Enseignant::findOrFail($id));
        session('ok', true);
        return redirect()->route('enseignants.index')->with('ok', __('Teacher successfully updated'))->with('teachers', Enseignant::all());
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enseignant  $enseignant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Enseignant::where('id', $id)->delete();
        session('ok', true);
        return redirect()->route('enseignants.index')->with('ok', __('Teacher successfully deleted'))->with('teachers', Enseignant::all());
    }
}
