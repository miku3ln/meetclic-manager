<?php

namespace App\Services;


class MenuService
{

    public function getMenu()
    {

        return [

            [
                'name' => 'Inicio',
                'icon' => 'fa-solid fa-house',
                'route' => 'managementHome',
            ],


            [
                'name' => 'Facturación',
                'icon' => 'fa-solid fa-file-invoice',
                'children' => [

                    [
                        'name' => 'Electronica',
                        'route' => 'managementInvoice',
                    ],


                ]

            ],
            [
                'name' => 'Música',
                'icon' => 'fa-solid fa-guitar fa-file-invoice',
                'children' => [


                    [
                        'name' => 'Violin',
                        'route' => 'managementViolin',
                    ],


                ]

            ],
            [
                'name'=>'Clientes',
                'icon'=>'fa-solid fa-users',
                'route' => 'managementRequests',

            ],
/*
            [
                'name'=>'Clientes',
                'icon'=>'fa-solid fa-users',
                'route'=>null,
                'url'=>'/customers'
            ],


            [
                'name' => 'Productos',
                'icon' => 'fa-solid fa-box',
                'route'=>null,
                'url'=>'/customers'
            ],


            [
                'name' => 'Configuración',
                'icon' => 'fa-solid fa-gear',

                'children' => [

                    [
                        'name' => 'Empresa',
                        'route' => 'business.index'
                    ],

                    [
                        'name' => 'Usuarios',
                        'route' => 'users.index'
                    ]

                ]
            ]*/


        ];

    }

}
