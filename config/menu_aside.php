<?php
// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'role' => ['1','2'],
            'title' => 'Dashboard',
            'root' => true,
            'bullet' => 'dot',
            'page' => 'dashboard',
            'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            // 'submenu' => [
            //     [
            //         'title' => 'Halaman Utama',
            //         'bullet' => 'dot',
            //         'page' => 'dashboard',
            //         'role' => ['1','2']
            //     ],
            //     [
            //         'title' => 'Data Fasilitas Kesehatan',
            //         'bullet' => 'dot',
            //         'page' => 'dashboard/data-faskes',
            //         'role' => ['1','2'],
            //     ],
            //     [
            //         'title' => 'Data Lain-lain',
            //         'bullet' => 'dot',
            //         'page' => 'dashboard/data-lain',
            //         'role' => ['1','2'],
            //     ]
            // ]
        ],

        // Custom
        // [
        //     'section' => 'Main Menu',
        //     'role' => ['1','2'],
        // ],
        [
            'section' => 'Admin',
            'role' => ['1'],
        ],
        [
            'title' => 'Data User',
            'root' => true,
            'icon' => 'media/svg/icons/General/User.svg',
            'page' => 'user',
            'new-tab' => false,
            'role' => ['1'],
        ],
    ]

];
