<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Presence;
use App\Repositories\MatiereRepository;
use Illuminate\Http\Request;

class PresenceController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($classe_id, $matiere_id = null)
    {
        $classe = Classe::findOrFail($classe_id);
        return view('presences.form')
            ->with('matiere', isset($matiere_id) ? Matiere::findOrFail($matiere_id) : null)
            ->with('classe', $classe)
            ->with('matieres', MatiereRepository::getMatieresPourClasse($classe_id))
            ->with('etudiants', $classe->etudiants);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request, $classe_id)
    {
        return $this->create($classe_id, $request->matiere);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $etudiantsPresents = $request->get('etudiants') ?? [];
        $classe = Classe::findOrFail($request->classe);
        foreach($classe->etudiants as $etudiant){
            $data = new Presence();
            $data->date_seance = $request->date;
            $data->seance_id = $request->seance;
            $data->etudiant_id = $etudiant->id;
            $data->present = in_array($etudiant->id, $etudiantsPresents);
            $data->save();
        }
        session('ok', true);
        return redirect()
            ->route('presences.index', [$classe->annee, $classe->id])
            ->with('ok', __('Attendence successfully created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit($ids_str)
    {
        $ids = explode(', ', $ids_str);
        if (count($ids ?? []) == 0) Presence::findOrFail(-1);
        $holder = Presence::findOrFail($ids[0]);
        return view('presences.form')
            ->with('classe', $holder->seance->matiere->module->classe)
            ->with('matiere', $holder->seance->matiere)
            ->with('presences', Presence::whereIn('id', $ids)->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $presences)
    {
        $etudiantsPresents = $request->get('ids') ?? [];
        $classe = Classe::findOrFail($request->classe);
        foreach(explode(', ',$presences) as $id){
            $data = Presence::findOrFail($id);
            $data->date_seance = $request->date;
            $data->seance_id = $request->seance;
            $data->present = in_array($id, $etudiantsPresents);
            $data->save();
        }
        session('ok', true);
        return redirect()
            ->route('presences.index', [$classe->annee, $classe->id])
            ->with('ok', __('Attendence successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids_str)
    { 
        $ids = explode(', ', $ids_str);
        foreach($ids as $id)
            Presence::destroy($id);
        session('ok', true);
        return back()->with('ok', __('Attendence successfully deleted'));
    }
}
