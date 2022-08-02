<?php

namespace App\Http\Controllers;

use App\Models\Parentt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParenttController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('parents.index')->with('parents', Parentt::all());
    }
    
    /**
     * Display a filtered listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $list = Parentt::where('cnp', 'like', '%'.($request->cnp ?? '').'%')
            ->where(DB::raw('CONCAT(prenom, nom)'), 'like', '%'.($request->nom ?? '').'%')
            ->whereExists(function ($query) use($request)  {
                $query->select(DB::raw(1))
                    ->from('etudiants')
                    ->whereColumn('etudiants.parent_id', 'parentts.id')
                    ->where(DB::raw('CONCAT(etudiants.prenom, etudiants.nom)'), 'like', '%'.($request->etudiant ?? '').'%');
            })->get();
        return view('parents.index')->with('parents', $list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parents.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = ProfileController::readForm($request, 'parent');
        session('ok', true);
        return redirect()->route('parents.index')->with('ok', __('Parent successfully created'))->with('parents', Parentt::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parentt  $parent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('parents.details')->with('parent', Parentt::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('parents.form')->with('edit', true)->with('parent', Parentt::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parentt  $parent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = ProfileController::readForm($request, 'parent', Parentt::findOrFail($id));
        session('ok', true);
        return redirect()->route('parents.index')->with('ok', __('Parent successfully updated'))->with('parents', Parentt::all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parentt  $parent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Parentt::destroy($id);
        session('ok', true);
        return redirect()->route('parents.index')->with('ok', __('Parent successfully deleted'))->with('parents', Parentt::all());
    }
}
