<?php
namespace App\Repositories;

use App\Models\Enseignant;
use App\Models\Epreuve;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Paiement;
use App\Models\Presence;
use App\Models\Seance;
use Illuminate\Support\Facades\DB;

class MatiereRepository
{
    public static function getMatieresPourClasse($classe_id)
    {
        if ($classe_id == null)
            return Matiere::where('id', 0)->get();

        return Matiere::whereExists(function($query) use($classe_id)
        {
            $query->select(DB::raw(1))
                     ->from('modules')
                     ->whereColumn('matieres.module_id', 'modules.id')
                     ->where('modules.classe_id', $classe_id);
        })->get();
    }
    
    public static function getSeancesPourClasse($classe_id)
    {
        if ($classe_id == null)
            return Seance::where('id', 0)->get();

        return Seance::whereExists(function($query) use($classe_id)
        {
            $query->select(DB::raw(1))
                     ->from('matieres')
                     ->whereColumn('seances.matiere_id', 'matieres.id')
                     ->whereExists(function($query) use($classe_id)
                     {
                         $query->select(DB::raw(1))
                                  ->from('modules')
                                  ->whereColumn('matieres.module_id', 'modules.id')
                                  ->where('modules.classe_id', $classe_id);
                     });
        })->orderBy('jour', 'asc')->orderBy('de', 'asc')->get();
    }
    
    public static function getPresencesEloquentPourClasse($classe_id)
    {
        if ($classe_id == null)
            return Presence::where('id', 0);

        return Presence::whereExists(function($query) use($classe_id)
        {
            $query->select(DB::raw(1))
                     ->from('seances')
                     ->whereColumn('presences.seance_id', 'seances.id')
                     ->whereExists(function($query) use($classe_id)
                     {
                         $query->select(DB::raw(1))
                                  ->from('matieres')
                                  ->whereColumn('seances.matiere_id', 'matieres.id')
                                  ->whereExists(function($query) use($classe_id)
                                  {
                                      $query->select(DB::raw(1))
                                               ->from('modules')
                                               ->whereColumn('matieres.module_id', 'modules.id')
                                               ->where('modules.classe_id', $classe_id);
                                  });
                     });
        });
    }
    
    public static function getEpreuvesPourClasse($classe_id)
    {
        if ($classe_id == null)
            return Epreuve::where('id', 0)->get();

        return Epreuve::whereExists(function($query) use($classe_id)
        {
            $query->select(DB::raw(1))
                     ->from('matieres')
                     ->whereColumn('epreuves.matiere_id', 'matieres.id')
                     ->whereExists(function($query) use($classe_id)
                     {
                         $query->select(DB::raw(1))
                                  ->from('modules')
                                  ->whereColumn('matieres.module_id', 'modules.id')
                                  ->where('modules.classe_id', $classe_id);
                     });
        })->get();
    }

    
    
    public static function getNotesEloquentPourClasse($classe_id)
    {
        if ($classe_id == null)
            return Note::where('id', 0);

        return Note::whereExists(function($query) use($classe_id)
        {
            $query->select(DB::raw(1))
                     ->from('epreuves')
                     ->whereColumn('notes.epreuve_id', 'epreuves.id')
                     ->whereExists(function($query) use($classe_id)
                     {
                         $query->select(DB::raw(1))
                                  ->from('matieres')
                                  ->whereColumn('epreuves.matiere_id', 'matieres.id')
                                  ->whereExists(function($query) use($classe_id)
                                  {
                                      $query->select(DB::raw(1))
                                               ->from('modules')
                                               ->whereColumn('matieres.module_id', 'modules.id')
                                               ->where('modules.classe_id', $classe_id);
                                  });
                     });
        });
    }
    
    public static function getNotesPourClasse($classe_id)
    {
        return MatiereRepository::getNotesEloquentPourClasse($classe_id)->get();
    }
    
    public static function getNotesPourEtudiant($etudiant_id)
    {
        return Note::where('etudiant_id', $etudiant_id)->get();
    }
    
    public static function getNotesPourParent($parent_id)
    {
        return Note::whereExists(function($query) use($parent_id)
        {
            $query->select(DB::raw(1))
                     ->from('etudiants')
                     ->whereColumn('notes.etudiant_id', 'etudiants.id')
                     ->where('etudiants.parent_id', $parent_id);
        })->get();
    }
    
    public static function getPaiementsPourParent($parent_id)
    {
        return Paiement::whereExists(function($query) use($parent_id)
        {
            $query->select(DB::raw(1))
                     ->from('etudiants')
                     ->whereNull('enseignant_id')
                     ->whereColumn('paiements.etudiant_id', 'etudiants.id')
                     ->where('etudiants.parent_id', $parent_id);
        })->get();
    }

    public static function getEnseignantsPossiblePourMatiere($id){

        if ($id == null)
            return Enseignant::all();

        $matiere = Matiere::find($id);

        if ($matiere == null)
            return Enseignant::all();

        return Enseignant::where('matiere_id', $id)
            ->orWhere(function ($query) use($id)
            {
                $query->where('enseignants.matiere_id', '<>', $id);
                // TODO finish sorting
            })->get();
    }
    
    public static function getTotalesPresencePourEtudiant($etudiant_id)
    {
        return [
            'present' => Presence::where('etudiant_id', $etudiant_id)->where('present', true )->get()->count(), 
            'absent'  => Presence::where('etudiant_id', $etudiant_id)->where('present', false)->get()->count()
        ];
    }

    public static function getPresencePourClasse($classe_id)
    {
        $query = MatiereRepository::getPresencesEloquentPourClasse($classe_id)
            ->groupBy('seance_id')->groupBy('date_seance')->select('seance_id', 'date_seance')->get();
        
        $presences = [];
        foreach ($query as $value) {
            array_push($presences, MatiereRepository::getPresenceInfoForSeance($value->seance_id, $value->date_seance));
        }

        return $presences;
    }

    private static function getPresenceInfoForSeance($seance_id, $date){
        $seance = Seance::find($seance_id);
        return [
            'matiere' => $seance->matiere->nom,
            'date' => Presence::where('seance_id', $seance_id)->where('date_seance', $date)->first()->dateSeance(),
            'ids' => implode(', ', Presence::where('seance_id', $seance_id)->where('date_seance', $date)->pluck('id')->toArray()),
            'present' => Presence::where('seance_id', $seance_id)->where('date_seance', $date)->where('present', true)->get()->count(),
            'absent' => Presence::where('seance_id', $seance_id)->where('date_seance', $date)->where('present', false)->get()->count(),
        ];
    }

    public static function getEtudiantsEloquentPourEnseignant($id)
    {
        return Etudiant::whereExists(function($query) use($id)
        {
            $query->select(DB::raw(1))
                     ->from('classes')
                     ->whereColumn('etudiants.classe_id', 'classes.id')
                     ->whereExists(function($query) use($id)
                     {
                         $query->select(DB::raw(1))
                                  ->from('modules')
                                  ->whereColumn('modules.classe_id', 'classes.id')
                                  ->whereExists(function($query) use($id)
                                {
                                    $query->select(DB::raw(1))
                                            ->from('matieres')
                                            ->whereColumn('matieres.module_id', 'modules.id')
                                            ->where('matieres.enseignant_id', $id);
                                });
                     });
        });
    }

    public static function getEtudiantsPourEnseignant($id)
    {
        return MatiereRepository::getEtudiantsEloquentPourEnseignant($id)->get();
    }

    public static function getEnseignantInfo($id)
    {
        return [
            'matieres' => Matiere::where('enseignant_id', $id)->get()->count(),
            'epreuves' => Epreuve::whereExists(function($query) use($id) {
                $query->select(DB::raw(1))
                    ->from('matieres')
                    ->whereColumn('epreuves.matiere_id', 'matieres.id')
                    ->where('matieres.enseignant_id', $id);
            })->get()->count(),
            'males' => MatiereRepository::getEtudiantsEloquentPourEnseignant($id)->where('sexe', 'M')->get()->count(),
            'females' => MatiereRepository::getEtudiantsEloquentPourEnseignant($id)->where('sexe', 'F')->get()->count(),
            'gains' => Paiement::whereNull('etudiant_id')->where('enseignant_id', $id)->sum('montant'),
        ];
    }

    public static function getEnseignantsPourEtudiant($id)
    {
        return Enseignant::whereExists(function($query) use($id) {
            $query->select(DB::raw(1))
                ->from('matieres')
                ->join('modules', 'modules.id', '=', 'matieres.module_id')
                ->join('etudiants', 'modules.classe_id', '=', 'etudiants.classe_id')
                ->whereColumn('matieres.enseignant_id', 'enseignants.id')
                ->where('etudiants.id', $id);
        })->get();
    }

    public static function getEnseignantsPourParent($id)
    {

        return Enseignant::whereExists(function($query) use($id) {
            $query->select('*')
                ->from('matieres')
                ->join('modules', 'modules.id', '=', 'matieres.module_id')
                ->join('etudiants', 'modules.classe_id', '=', 'etudiants.classe_id')
                ->whereColumn('matieres.enseignant_id', 'enseignants.id')
                ->where('etudiants.parent_id', $id);
        })->get();
    }
}