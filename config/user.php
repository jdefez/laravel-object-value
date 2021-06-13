<?php

return [
    'settings' => [
        'declare_for_others' => [
            'description' => 'Permet à un utilisateur de faire une déclaration pour le compte d‘un autre utilisateur.',
            'name' => 'déclaration pour autrui.',
            'default' => false,
            'values' => [true, false],
        ],
        'declaration_with_travel_time' => [
            'description' => 'L‘utilisateur peut déclarer les trajets relatifs à ses délégations.',
            'name' => 'Temps de trajet des déclarations.',
            'default' => false,
            'values' => [true, false],
        ],
        'reunion' => [
            'description' => 'L‘utilisateur peut organiser des réunions.',
            'name' => 'Organiser des réunions.',
            'default' => false,
            'values' => [true, false],
        ],
        'reunion_with_travel_time' => [
            'description' => 'L‘utilisateur peut déclarer les trajets relatifs aux réunions.',
            'name' => 'Déclarer les temps de trajet des réunions.',
            'default' => false,
            'values' => [true, false],
        ],
        'time_cutting' => [
            'description' => 'Unité de temps utilisée pour les déclarations de l‘utilisateur.',
            'name' => 'Collège de l‘utilisateur',
            'default' => 'minute',
            'values' => ['minute', 'heure', 'demie-journée', 'journée'],
        ],
    ]
];
