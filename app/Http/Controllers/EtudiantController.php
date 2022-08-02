<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Repositories\MatiereRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->profile === 'admin')
            return view('students.index')->with('students', Etudiant::whereNotNull('cne')->get())->with('pending_students', Etudiant::whereNull('cne')->get());
        if (auth()->user()->profile === 'teacher')
            return view('students.index')->with('students', MatiereRepository::getEtudiantsPourEnseignant(auth()->user()->enseignant->id));
        $student = auth()->user()->etudiant;
        return view('students.index')->with('students', auth()->user()->profile === 'student' ? Etudiant::where('classe_id', $student != null ? $student->classe_id : '-1')->get() : Etudiant::all());
    }
    
    /**
     * Display a filtered listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $list = Etudiant::whereNotNull('cne')->where('cne', 'like', '%'.($request->cne ?? '').'%')
            ->where(DB::raw('CONCAT(prenom, nom)'), 'like', '%'.($request->nom ?? '').'%')->get();
            //->orWhere('classe', 'like', '%'.($request->classe ?? '').'%');
        return view('students.index')->with('students', $list)->with('pending_students', Etudiant::whereNull('cne')->get());;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.form')->with('filieres', getIDNomArray(Filiere::all()))->with('classes', getIDAffichageArray(Classe::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = ProfileController::readForm($request, 'student');
        session('ok', true);
        return redirect()->route('etudiants.index')->with('ok', __('Student successfully created'))->with('students', Etudiant::all());
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('students.details')->with('student', Etudiant::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('students.form')->with('edit', true)->with('student', Etudiant::findOrFail($id))->with('filieres', getIDNomArray(Filiere::all()))->with('classes', getIDAffichageArray(Classe::whereNotNull('annee')->whereNotNull('niveau')->whereNotNull('nom')->get()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = ProfileController::readForm($request, 'student', Etudiant::findOrFail($id));
        session('ok', true);
        return redirect()->route('etudiants.index')->with('ok', __('Student successfully updated'))->with('students', Etudiant::all());
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Etudiant::where('id', $id)->delete();
        session('ok', true);
        return redirect()->route('etudiants.index')->with('ok', __('Student successfully deleted'))->with('students', Etudiant::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function parent(Request $request)
    {
        $data = Etudiant::where('cne', $request->cne)->first();
        if ($data == null)
                return back()->with('error', __('No Student Found'))->withInput();
        $data->parent_id = $request->parent;
        $data->save();
        session('ok', true);
        return back()->with('ok', __('Student successfully linked'));
    
    }
}
