<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Localisations disponibles pour les prévisions de marées
    |--------------------------------------------------------------------------
    | Chaque entrée contient :
    | - un nom de région
    | - une liste de communes avec leurs coordonnées approximatives
    */

    'locations' => [

        'dakar' => [
            'name' => 'Dakar',
            'communes' => [
                'dakar' => ['name' => 'Dakar', 'lat' => 14.6928, 'lng' => -17.4467],
                'yoff' => ['name' => 'Yoff', 'lat' => 14.7390, 'lng' => -17.4700],
                'soumbedioune' => ['name' => 'Soumbédioune', 'lat' => 14.7030, 'lng' => -17.4560],
                'hann' => ['name' => 'Hann', 'lat' => 14.7090, 'lng' => -17.4390],
                'yarakh' => ['name' => 'Yarakh', 'lat' => 14.6800, 'lng' => -17.4500],
                'thiaroye-sur-mer' => ['name' => 'Thiaroye-sur-Mer', 'lat' => 14.6820, 'lng' => -17.4100],
            ],
        ],

        'thies' => [
            'name' => 'Thiès',
            'communes' => [
                'mbour' => ['name' => 'Mbour', 'lat' => 14.4210, 'lng' => -16.9640],
                'joal-fadiouth' => ['name' => 'Joal-Fadiouth', 'lat' => 14.2700, 'lng' => -16.9300],
                'nianing' => ['name' => 'Nianing', 'lat' => 14.3150, 'lng' => -16.9500],
                'popenguine' => ['name' => 'Popenguine', 'lat' => 14.3850, 'lng' => -16.9400],
            ],
        ],

        'fatick' => [
            'name' => 'Fatick',
            'communes' => [
                'foundiougne' => ['name' => 'Foundiougne', 'lat' => 14.2830, 'lng' => -16.4830],
                'djifer' => ['name' => 'Djifer', 'lat' => 14.1970, 'lng' => -16.5640],
                'palmarin' => ['name' => 'Palmarin', 'lat' => 14.2000, 'lng' => -16.5000],
            ],
        ],

        'kaolack' => [
            'name' => 'Kaolack',
            'communes' => [
                'ndangane' => ['name' => 'Ndangane', 'lat' => 14.1330, 'lng' => -16.2170],
                'sokone' => ['name' => 'Sokone', 'lat' => 14.1670, 'lng' => -16.2500],
            ],
        ],

        'ziguinchor' => [
            'name' => 'Ziguinchor',
            'communes' => [
                'elinkine' => ['name' => 'Elinkine', 'lat' => 12.6330, 'lng' => -16.6330],
                'kafountine' => ['name' => 'Kafountine', 'lat' => 12.5330, 'lng' => -16.7500],
                'cap-skirring' => ['name' => 'Cap Skirring', 'lat' => 12.4170, 'lng' => -16.7500],
            ],
        ],

        'saint-louis' => [
            'name' => 'Saint-Louis',
            'communes' => [
                'goxu-mbath' => ['name' => 'Goxu Mbath', 'lat' => 16.0160, 'lng' => -16.4830],
                'guet-ndar' => ['name' => 'Guet-Ndar', 'lat' => 16.0150, 'lng' => -16.4850],
                'hydrobase' => ['name' => 'Hydrobase', 'lat' => 16.0200, 'lng' => -16.4900],
            ],
        ],

    ],

];
