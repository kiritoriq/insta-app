<?php
// Header menu
return [

    'items' => [
        [],
        [
            'title' => ' Tambah Surat/ Dokumen',
            'class' => 'text-white btn-header-menu',
            'root' => true,
            'toggle' => 'click',
            'icon' => 'media/svg/icons/Navigation/Plus.svg',
            'class-icon' => 'svg-icon-white',
            'submenu' => [
                'type' => 'classic',
                'alignment' => 'left',
                'items' => [
                    [
                        'title' => 'Naskah Dinas (Draft)',
                        'bullet' => 'dot',
                        'icon' => 'media/svg/icons/Files/Selected-file.svg',
                        'title' => 'Naskah Dinas',
                        'submenu' => [
                            [
                                'title' => 'Surat Biasa',
                                'icon' => 'media/svg/icons/Files/Selected-file.svg',
                                'page' => 'naskah-dinas/tambah-surat-biasa'
                            ],
                            [
                                'title' => 'Surat Edaran',
                                'icon' => 'media/svg/icons/Files/Selected-file.svg',
                                'page' => 'naskah-dinas/tambah-surat-edaran'
                            ],
                            [
                                'title' => 'Surat Undangan',
                                'icon' => 'media/svg/icons/Files/Selected-file.svg',
                                'page' => 'naskah-dinas/tambah-surat-undangan'
                            ],
                            [
                                'title' => 'Nota Dinas',
                                'icon' => 'media/svg/icons/Files/Selected-file.svg',
                                'page' => 'naskah-dinas/tambah-nota-dinas'
                            ]
                        ],
                    ],
                    [
                        'title' => 'Surat Masuk',
                        'bullet' => 'dot',
                        'icon' => 'media/svg/icons/Communication/Incoming-mail.svg',
                        'title' => 'Surat Masuk',
                        'page' => 'tambah-surat-masuk'
                    ],
                    [
                        'title' => 'Arsip Inaktif',
                        'bullet' => 'dot',
                        'icon' => 'media/svg/icons/Communication/Archive.svg',
                        'title' => 'Arsip Inaktif',
                        'page' => 'custom/apps/inbox'
                    ]
                ]
            ]
        ],
    ]

];
