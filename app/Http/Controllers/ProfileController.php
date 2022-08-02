<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Module;
use App\Models\Paiement;
use App\Models\Parentt;
use App\Models\Presence;
use App\Models\Seance;
use App\Models\TypeEpreuve;
use App\Models\User;
use App\Repositories\MatiereRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function account()
    {
        if (auth()->user()->profile === 'student')
            return view('students.details')->with('edit', true)->with('student', Etudiant::findOrFail(auth()->user()->etudiant->id));
        if (auth()->user()->profile === 'parent')
            return view('parents.details')->with('edit', true)->with('parent', Parentt::findOrFail(auth()->user()->parent->id));
        if (auth()->user()->profile === 'teacher')
            return view('teachers.details')->with('edit', true)->with('teacher', Enseignant::findOrFail(auth()->user()->enseignant->id));
        return redirect('login');
    }
    public function dashboard()
    {
        if (auth()->user()->profile === 'student')
            return view('students.dashboard')
                ->with('student', Etudiant::findOrFail(auth()->user()->etudiant->id))
                ->with('notes', MatiereRepository::getNotesPourEtudiant(auth()->user()->etudiant->id))
                ->with('presence', MatiereRepository::getTotalesPresencePourEtudiant(auth()->user()->etudiant->id));

        if (auth()->user()->profile === 'parent')
            return view('parents.dashboard')
                ->with('parent', Parentt::findOrFail(auth()->user()->parent->id))
                ->with('notes', MatiereRepository::getNotesPourParent(auth()->user()->parent->id))
                ->with('paiements', MatiereRepository::getPaiementsPourParent(auth()->user()->parent->id))
                ->with('depenses', MatiereRepository::getPaiementsPourParent(auth()->user()->parent->id)->sum('montant'))
                ->with('students', Etudiant::where('parent_id', auth()->user()->parent->id)->get());

        if (auth()->user()->profile === 'teacher')
            return view('teachers.dashboard')
                ->with('students', MatiereRepository::getEtudiantsPourEnseignant(auth()->user()->enseignant->id))
                ->with('info', MatiereRepository::getEnseignantInfo(auth()->user()->enseignant->id));

        if (auth()->user()->profile === 'admin')
            return view('admin.dashboard')
                ->with('females', Etudiant::where('sexe', 'F')->get()->count())
                ->with('males', Etudiant::where('sexe', 'M')->get()->count())
                ->with('total_pending', Etudiant::whereNull('cne')->count())
                ->with('total_students', Etudiant::whereNotNull('id')->count())
                ->with('total_parents', Parentt::all()->count())
                ->with('total_teachers', Enseignant::all()->count())
                ->with('total_earnings', Paiement::whereNull('enseignant_id')->whereNotNull('etudiant_id')->sum('montant'))
                ->with('earnings', $this->getLast9MonthsFees())
                ->with('expenses', $this->getLast3MonthsExpenses());
        return redirect('login');
    }

    public static function readForm(Request $request, string $profile, $old = null)
    {
        $data = null;

        if ($old == null) {
            if ($profile === 'student')
                $data = new Etudiant();
            else if ($profile === 'parent')
                $data = new Parentt();
            else if ($profile === 'teacher')
                $data = new Enseignant();
        } else {
            $data = $old;
        }

        if (isset($request->user)) $data->user_id = $request->user;
        if (isset($request->prenom)) $data->prenom = $request->prenom;
        if (isset($request->nom)) $data->nom = $request->nom;
        if (isset($request->sexe)) $data->sexe = $request->sexe;
        if (isset($request->ddn)) $data->date_de_naissance = $request->ddn;
        if (isset($request->occupation)) $data->occupation = $request->occupation;
        if (isset($request->titre)) $data->titre = $request->titre;
        if (isset($request->tel)) $data->tel = $request->tel;
        if (isset($request->email)) $data->email = $request->email;
        if (isset($request->adresse)) $data->adresse = $request->adresse;
        if (isset($request->filiere)) $data->classe_id = ClasseController::findDefaultClasseFor($request->filiere);
        if (isset($request->classe)) $data->classe_id = $request->classe;
        if (isset($request->cne)) $data->cne = $request->cne;
        if (isset($request->cnp)) $data->cnp = $request->cnp;
        if (isset($request->cin)) $data->cin = $request->cin;
        if (isset($request->bio)) $data->bio = $request->bio;

        if ($old == null) {
            if (auth()->user()->profile === 'admin'){
                $user = User::factory()->create([
                    'profile' => $profile,
                    'name' => $data->prenom.$data->nom,
                    'email' => $data->email
                ]);
                $data->user_id = $user->id;
            }
        }

        if (isset($request->photo)) $data->image = explode('/', $request->photo->store('public/photos/'.($data->user_id ?? auth()->user()->id)))[3];
        if (isset($request->cv)) $data->cv = explode('/', $request->cv->store('public/cv/'.($data->user_id ?? auth()->user()->id)))[3];


        $data->save();

        if ($profile === 'student') {
            foreach($request->docs ?? [] as $doc){
                $doc->store('public/docs/'.($data->etudiant_id ?? ($data->user_id ?? auth()->user()->id)));
            }
        }

        return $data;
    }

    public function deepFilter($annee = null, $classe = null, $module = null, $matiere = null, $view = null)
    {
        if (!in_array($view, ['matieres', 'seances', 'epreuves', 'notes', 'presences']))
            return redirect()->route('home');

        if ($annee == null && auth()->user()->profile === 'student'){
            if ($view === 'presences')
                return view('presences.etudiant')
                    ->with('etudiant', Etudiant::findOrFail(auth()->user()->etudiant->id))
                    ->with('presence', MatiereRepository::getTotalesPresencePourEtudiant(auth()->user()->etudiant->id))
                    ->with('presences', Presence::where('etudiant_id', auth()->user()->etudiant->id)->orderBy('date_seance')->get());
            $mon_classe = auth()->user()->etudiant->classe;
            if ($mon_classe != null) {
                $annee = $mon_classe->annee;
                $classe = $mon_classe->id;
            }
        }
        
        if ($annee === 'all') $annee = null;
        else if ($annee == null) $annee = Classe::select('annee')->whereNotNull('annee')->distinct()->orderBy('annee', 'desc')->pluck('annee')->first();
        

        $layout = view($view === 'presences' ? 'presences.index' : $view);

        if ($annee == null)
            return $layout->with('annees', Classe::select('annee')->whereNotNull('annee')->distinct()->pluck('annee')->toArray());

        $layout = $layout->with('annee', $annee);

        if ($classe == null)
            return $layout->with('classes', Classe::where('annee', $annee)->whereNotNull('nom')->distinct()->get());


        $layout = $layout->with('classe', Classe::where('id', $classe)->first())->with('matieres', MatiereRepository::getMatieresPourClasse($classe));

        if ($view === 'matieres')
            return $layout->with('modules', Module::where('classe_id', $classe)->get())->with('enseignants', MatiereRepository::getEnseignantsPossiblePourMatiere($matiere));
        
        if ($view === 'seances')
            return $layout->with('seances', MatiereRepository::getSeancesPourClasse($classe));

        if ($view === 'epreuves')
                return $layout->with('types', TypeEpreuve::all())->with('epreuves', MatiereRepository::getEpreuvesPourClasse($classe));

        if ($view === 'notes')
            return $layout->with('etudiants', Etudiant::where('classe_id', $classe)->get())->with('epreuves', MatiereRepository::getEpreuvesPourClasse($classe))->with('notes', MatiereRepository::getNotesPourClasse($classe));

        if ($view === 'presences')
            return $layout->with('presences', MatiereRepository::getPresencePourClasse($classe));

        
    }

    public function deepFilterPOST(Request $request, $annee = null, $classe = null, $module = null, $matiere = null, $view = null)
    {
        if (!in_array($view, ['matieres', 'seances', 'epreuves', 'notes', 'presences']))
            return redirect()->route('home');

        if (isset($request->annee)) $annee = $request->annee;
        if (isset($request->classe)) $classe = $request->classe;
        if (isset($request->module)) $module = $request->module;
        if (isset($request->matiere)) $matiere = $request->matiere;

        return redirect()->route($view.'.index', [$annee, $classe, $module, $matiere]);
    }


    public function matieres_index($annee = null, $classe = null, $module = null, $matiere = null)
    {
        return $this->deepFilter($annee, $classe, $module, $matiere, 'matieres');
    }

    public function matieres_crud(Request $request, $annee = null, $classe = null, $module = null, $matiere = null)
    {
        return $this->deepFilterPOST($request, $annee, $classe, $module, $matiere, 'matieres');
    }



    public function seances_index($annee = null, $classe = null, $module = null, $matiere = null)
    {
        return $this->deepFilter($annee, $classe, $module, $matiere, 'seances');
    }

    public function seances_crud(Request $request, $annee = null, $classe = null, $module = null, $matiere = null)
    {
        return $this->deepFilterPOST($request, $annee, $classe, $module, $matiere, 'seances');
    }



    public function epreuves_index($annee = null, $classe = null, $module = null, $matiere = null)
    {
        return $this->deepFilter($annee, $classe, $module, $matiere, 'epreuves');
    }

    public function epreuves_crud(Request $request, $annee = null, $classe = null, $module = null, $matiere = null)
    {
        return $this->deepFilterPOST($request, $annee, $classe, $module, $matiere, 'epreuves');
    }


    
    public function notes_index($annee = null, $classe = null, $module = null, $matiere = null)
    {
        return $this->deepFilter($annee, $classe, $module, $matiere, 'notes');
    }

    public function notes_crud(Request $request, $annee = null, $classe = null, $module = null, $matiere = null)
    {
        return $this->deepFilterPOST($request, $annee, $classe, $module, $matiere, 'notes');
    }


    
    public function presences_index($annee = null, $classe = null, $module = null, $matiere = null)
    {
        return $this->deepFilter($annee, $classe, $module, $matiere, 'presences');
    }

    public function presences_crud(Request $request, $annee = null, $classe = null, $module = null, $matiere = null)
    {
        return $this->deepFilterPOST($request, $annee, $classe, $module, $matiere, 'presences');
    }

    public function getLast3MonthsExpenses() {
        $month = now()->month;
        return [
            [
                'key' => getMonthShort($month),
                'value' => Paiement::whereNull('etudiant_id')->whereNotNull('enseignant_id')->whereMonth('date_paiement', $month)->sum('montant')
            ],
            [
                'key' => getMonthShort($month = ($month + 11) % 12),
                'value' => Paiement::whereNull('etudiant_id')->whereNotNull('enseignant_id')->whereMonth('date_paiement', $month)->sum('montant')
            ],
            [
                'key' => getMonthShort($month = ($month + 11) % 12),
                'value' => Paiement::whereNull('etudiant_id')->whereNotNull('enseignant_id')->whereMonth('date_paiement', $month)->sum('montant')
            ]
        ];
    }

    public function getLast9MonthsFees() {
        $month = now()->month;
        $labels = [];
        $values = [];

        for ($i=0; $i < 9; $i++) { 
            array_push($labels, getMonthShort($month));
            array_push($values, Paiement::whereNotNull('etudiant_id')->whereNull('enseignant_id')->whereMonth('date_paiement', $month)->sum('montant'));
            $month = ($month + 11) % 12;
            if ($month == 0) $month = 12;
        }

        return [
            'labels' => array_reverse($labels),
            'values' => array_reverse($values),
        ];
    }
}
