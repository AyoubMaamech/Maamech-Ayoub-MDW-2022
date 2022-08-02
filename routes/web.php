<?php

use App\Http\Controllers\{
    ClasseController,
    EnseignantController,
    EpreuveController,
    EtudiantController,
    FiliereController,
    MatiereController,
    ModuleController,
    NoteController,
    PaiementController,
    ParenttController,
    PresenceController,
    ProfileController,
    SeanceController,
    TypeEpreuveController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['lang', 'auth'])->withoutMiddleware('profile')->group(function(){
    Route::resource('parents', ParenttController::class)->only('create', 'store');
    Route::resource('etudiants', EtudiantController::class)->only('create', 'store');
    Route::resource('enseignants', EnseignantController::class)->only('create', 'store');

    Route::view('/map', 'map')->name('map');
});

Route::middleware(['lang', 'auth', 'profile'])->group(function(){
    Route::get('/account', [ProfileController::class, 'account'])->name('account');
    Route::get('/', [ProfileController::class, 'dashboard'])->name('home');
    
    //CRUD
    Route::resource('parents',     ParenttController::class   )->except('create', 'store');
    Route::resource('etudiants',   EtudiantController::class  )->except('create', 'store');
    Route::resource('enseignants', EnseignantController::class)->except('create', 'store');

    Route::resource('classes',     ClasseController::class )->except('show');
    Route::resource('filieres',    FiliereController::class)->except('show');

    Route::resource('modules',       ModuleController::class     )->only(['store', 'edit', 'update', 'destroy']);
    Route::resource('matieres',      MatiereController::class    )->only(['store', 'edit', 'update', 'destroy']);
    Route::resource('seances',       SeanceController::class     )->only(['store', 'edit', 'update', 'destroy']);
    Route::resource('type_epreuves', TypeEpreuveController::class)->only(['store', 'edit', 'update', 'destroy']);
    Route::resource('epreuves',      EpreuveController::class    )->only(['store', 'edit', 'update', 'destroy']);
    Route::resource('notes',         NoteController::class       )->only(['store', 'edit', 'update', 'destroy']);
    Route::resource('presences',     PresenceController::class   )->only(['store', 'edit', 'update', 'destroy']);
    Route::resource('paiements',     PaiementController::class   )->only(['store', 'edit', 'update', 'destroy']);

    //Filtres Recherche
    Route::post('/filter/enseignants', [EnseignantController::class, 'filter'])->name('enseignants.index.filter');
    Route::post('/filter/etudiants', [EtudiantController::class, 'filter'])->name('etudiants.index.filter');
    Route::post('/filter/parents', [ParenttController::class, 'filter'])->name('parents.index.filter');
    Route::post('/filter/classe', [ClasseController::class, 'filter'])->name('classes.index.filter');

    // CRUD Avec Re-Utilisation du code
    Route::get('/filter/matieres/{annee?}/{classe?}/{module?}/{matiere?}',   [ProfileController::class, 'matieres_index' ])->name('matieres.index');
    Route::post('/filter/matieres/{annee?}/{classe?}/{module?}/{matiere?}',  [ProfileController::class, 'matieres_crud'  ])->name('matieres.index.filter');
    Route::get('/filter/seances/{annee?}/{classe?}/{module?}/{matiere?}',    [ProfileController::class, 'seances_index'  ])->name('seances.index');
    Route::post('/filter/seances/{annee?}/{classe?}/{module?}/{matiere?}',   [ProfileController::class, 'seances_crud'   ])->name('seances.index.filter');
    Route::get('/filter/epreuves/{annee?}/{classe?}/{module?}/{matiere?}',   [ProfileController::class, 'epreuves_index' ])->name('epreuves.index');
    Route::post('/filter/epreuves/{annee?}/{classe?}/{module?}/{matiere?}',  [ProfileController::class, 'epreuves_crud'  ])->name('epreuves.index.filter');
    Route::get('/filter/notes/{annee?}/{classe?}/{module?}/{matiere?}',      [ProfileController::class, 'notes_index'    ])->name('notes.index');
    Route::post('/filter/notes/{annee?}/{classe?}/{module?}/{matiere?}',     [ProfileController::class, 'notes_crud'     ])->name('notes.index.filter');
    Route::get('/filter/presences/{annee?}/{classe?}/{module?}/{matiere?}',  [ProfileController::class, 'presences_index'])->name('presences.index');
    Route::post('/filter/presences/{annee?}/{classe?}/{module?}/{matiere?}', [ProfileController::class, 'presences_crud' ])->name('presences.index.filter');
    
    
    Route::get('/presences/{classe_id}/create',  [PresenceController::class, 'create'])->name('presences.create');
    Route::post('/presences/{classe_id}/create', [PresenceController::class, 'filter'])->name('presences.create.filter');

    Route::get('/paiements/frais'       , [PaiementController::class, 'frais'       ])->name('paiements.frais');
    Route::get('/paiements/mes_frais'   , [PaiementController::class, 'mes_frais'   ])->name('paiements.mes_frais');
    Route::get('/paiements/salaires'    , [PaiementController::class, 'salaires'    ])->name('paiements.salaires');
    Route::get('/paiements/mes_salaires', [PaiementController::class, 'mes_salaires'])->name('paiements.mes_salaires');

    Route::post('/assigner/parent/etudiant', [EtudiantController::class, 'parent'])->name('etudiants.parent');
});





Route::redirect('/dashboard', '/');

require __DIR__.'/auth.php';
