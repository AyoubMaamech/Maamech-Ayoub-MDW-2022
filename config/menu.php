<?php

return [

    'Dashboard' => [
        'profile'   => ['student', 'parent', 'teacher', 'admin'],
        'icon'   => 'flaticon-dashboard',
        'route'  => 'home',
    ],
    'Students' => [
        'profile'   => ['student', 'teacher', 'admin'],
        'icon'   => 'flaticon-classmates',
        'route'  => 'etudiants.index',
    ],
    'Teachers' => [
        'profile'   => ['student', 'parent', 'teacher', 'admin'],
        'icon'   => 'flaticon-multiple-users-silhouette',
        'route' => 'enseignants.index',
    ],
    'Parents' => [
        'profile'   => ['admin'],
        'icon'   => 'flaticon-couple',
        'route' => 'parents.index',
    ],
    'Acconunt' => [
        'profile'   => ['student', 'parent', 'teacher', 'admin'],
        'icon'   => 'flaticon-technological',
        'children' => [
            [
                'name'  => 'Fees Collection',
                'profile'  => ['admin'],
                'route' => 'paiements.frais',
            ],
            [
                'name'  => 'Teacher Payment',
                'profile'  => ['admin'],
                'route' => 'paiements.salaires',
            ],
            [
                'name'  => 'Fees',
                'profile'  => ['parent', 'student'],
                'route' => 'paiements.mes_frais',
            ],
            [
                'name'  => 'Salary',
                'profile'  => ['teacher'],
                'route' => 'paiements.mes_salaires',
            ],
        ]
    ],
    'Classes' => [
        'profile'   => ['teacher', 'admin'],
        'icon'   => 'flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler',
        'route' => 'classes.index',
    ],
    'Subjects' => [
        'profile'   => ['student', 'parent', 'teacher', 'admin'],
        'route' => 'matieres.index',
        'icon'   => 'flaticon-open-book',
    ],
    'Class Routine' => [
        'profile'   => ['student', 'parent', 'teacher', 'admin'],
        'route' => 'seances.index',
        'icon'   => 'flaticon-calendar',
    ],
    'Attendence' => [
        'profile'   => ['student', 'parent', 'teacher', 'admin'],
        'route' => 'presences.index',
        'icon'   => 'flaticon-checklist',
    ],    
    'Exams' => [
        'profile'   => ['student', 'parent', 'teacher', 'admin'],
        'icon'   => 'flaticon-shopping-list',
        'children' => [
            [
                'name'  => 'Exam Schedule',
                'profile'  => ['student', 'parent', 'teacher', 'admin'],
                'route' => 'epreuves.index',
            ],
            [
                'name'  => 'Exam Grades',
                'profile'  => ['teacher', 'admin'],
                'route' => 'notes.index',
            ],
        ]
    ],
    /*'Map' => [
        'profile'   => ['student', 'parent', 'teacher', 'admin'],
        'route' => 'map',
        'icon'   => 'flaticon-planet-earth',
    ],*/
    'Account' => [
        'profile'   => ['student', 'parent', 'teacher'],
        'route' => 'account',
        'icon'   => 'flaticon-settings',
    ],
];