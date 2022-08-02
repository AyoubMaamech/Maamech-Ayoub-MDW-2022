<?php

namespace Database\Seeders;

use App\Models\{Classe, Enseignant, Etudiant, Filiere, Parentt, User};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create 1 admin
        User::factory()->create([
            'profile' => 'admin',
        ]);
        // Create 2 teacher
        User::factory()->count(2)->create([
            'profile' => 'teacher',
        ]);
        // Create 2 parents
        User::factory()->count(2)->create([
            'profile' => 'parent',
        ]);
        // Create 3 users
        User::factory()->count(3)->create();

        $nbrUsers = 8;




        Enseignant::factory()->create([
            'user_id' => 2,
        ]);
        Enseignant::factory()->create([
            'user_id' => 3,
        ]);

        $nbrEnseigants = 2;




        Parentt::factory()->create([
            'user_id' => 4,
        ]);
        Parentt::factory()->create([
            'user_id' => 5,
        ]);

        $nbrParentts = 2;




        Filiere::factory()->create([
            'nom' => 'Sciences Économiques & Gestion',
        ]); Classe::factory()->create(['filiere_id' => 1, 'annee' => null, 'niveau' => null, 'nom' => null]);
        Filiere::factory()->create([
            'nom' => 'Lettres',
        ]); Classe::factory()->create(['filiere_id' => 2, 'annee' => null, 'niveau' => null, 'nom' => null]);
        Filiere::factory()->create([
            'nom' => 'Mathématique',
        ]); Classe::factory()->create(['filiere_id' => 3, 'annee' => null, 'niveau' => null, 'nom' => null]);
        Filiere::factory()->create([
            'nom' => 'Sciences Expérimentales',
        ]); Classe::factory()->create(['filiere_id' => 4, 'annee' => null, 'niveau' => null, 'nom' => null]);
        Filiere::factory()->create([
            'nom' => 'Informatique',
        ]); Classe::factory()->create(['filiere_id' => 5, 'annee' => null, 'niveau' => null, 'nom' => null]);

        $nbrFilieres = 5;




        Classe::factory()->create([
            'filiere_id' => 1,
            'nom' => '1',
        ]);        
        Classe::factory()->create([
            'filiere_id' => 1,
            'nom' => '2',
        ]);        
        Classe::factory()->create([
            'filiere_id' => 1,
            'nom' => '3',
        ]);
        Classe::factory()->create([
            'filiere_id' => 4,
            'nom' => '1',
        ]);
        Classe::factory()->create([
            'filiere_id' => 4,
            'nom' => '2',
        ]);

        $nbrClasse = 5;




        Etudiant::factory()->create([
            'user_id' => 6,
            'parent_id' => 1,
            'classe_id' => 1,
        ]);
        Etudiant::factory()->create([
            'user_id' => 7,
            'parent_id' => 2,
            'classe_id' => 1,
        ]);
        Etudiant::factory()->create([
            'user_id' => 8,
            'parent_id' => 2,
            'classe_id' => 4,
        ]);

        $nbrEtudiants = 3;
    }
}
