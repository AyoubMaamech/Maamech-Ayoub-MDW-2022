<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{

    public function frais()
    {
        return view('paiements')->with('profile', 'student')->with('paiements', Paiement::whereNotNull('etudiant_id')->whereNull('enseignant_id')->get());
    }

    public function salaires()
    {
        return view('paiements')->with('profile', 'teacher')->with('paiements', Paiement::whereNull('etudiant_id')->whereNotNull('enseignant_id')->get());
    }

    public function mes_frais()
    {
        $ids = [];
        if (auth()->user()->profile === 'student')
            $ids = [auth()->user()->etudiant->id];
        if (auth()->user()->profile === 'parent')
            foreach(auth()->user()->parent->etudiants as $etudiant)
                array_push($ids, $etudiant->id);
        return view('paiements')->with('profile', 'student')->with('paiements', Paiement::whereIn('etudiant_id', $ids)->whereNull('enseignant_id')->get());
    }

    public function mes_salaires()
    {
        return view('paiements')->with('profile', 'teacher')->with('paiements', Paiement::whereNull('etudiant_id')->where('enseignant_id', auth()->user()->enseignant->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Paiement();
        $data->pour = $request->pour;
        $data->date_paiement = $request->date_paiement;
        $data->montant = $request->montant;
        if( isset($request->cne) ) {
            $holder = Etudiant::where('cne', $request->cne)->first();
            if ($holder == null)
                return back()->with('error', __('No Student Found'))->withInput();
            $data->etudiant_id = $holder->id;
        }
        if( isset($request->cin) ) {
            $holder = Enseignant::where('cin', $request->cin)->first();
            if ($holder == null)
                return back()->with('error', __('No Teacher Found'))->withInput();
            $data->enseignant_id = $holder->id;
        }
        $data->save();
        return back()->with('ok', __('Payment successfully created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matiere  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back()->with('paiement', Paiement::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Paiement::findOrFail($id);
        $data->pour = $request->pour;
        $data->date_paiement = $request->date_paiement;
        $data->montant = $request->montant;
        if( isset($request->cne) ) {
            $holder = Etudiant::where('cne', $request->cne)->first();
            if ($holder == null)
                return back()->with('error', __('No Student Found'));
            $data->etudiant_id = $holder->id;
        }
        if( isset($request->cin) ) {
            $holder = Enseignant::where('cin', $request->cin)->first();
            if ($holder == null)
                return back()->with('error', __('No Teacher Found'));
            $data->enseignant_id = $holder->id;
        }
        $data->save();
        return back()->with('ok', __('Payment successfully updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Paiement::destroy($id);
        return back()->with('ok', __('Payment successfully deleted'));
    }
}
