<?php
namespace App\Utils\Mikrotik;

class MikrotickManager
{
    public $mikrotiksManager = [];
//https://github.com/BenMenking/routeros-api
//https://github.com/jarobaina/Mikrotik-Center-PHP
    public function __construct(array $attributes = [])
    {
        //HER ADD NEWS MIKROTIKS

        $this->mikrotiksManager = [
            [
                'name' => 'Home Lema',
                'id' => 1,
                'ip' => '192.168.0.1',
                'user' => 'admin',
                'password' => 'meetclic89',
            ],
            ['name' => 'Migu3ln',
                'id' => 2,
                'ip' => '192.168.5.1',
                'user' => 'admin',
                'password' => 'MEETCLIC',
            ]

        ];


    }

    public function getEventsManager()
    {
        $mikrotiksManagerEvent = [
            [
                'id' => '1',
                'name' => 'Estado Interfaces',
                'command' => '/interface/ethernet/getall',
                'code' => '/interface/ethernet/getall',

            ],
            [
                'id' => '2',
                'name' => 'Salud-Mikrotik ',
                'command' => 'health',
                'code' => 'HEALTH',

            ],
            [
                'id' => '3',
                'name' => 'Estado Usuarios  ',
                'command' => 'statesUsers',
                'code' => 'stateUsers',

            ],
            [
                'id' => 4,
                'name' => 'Comandos Sin Parametros',
                'command' => 'cualqier comando agregar...',
                'code' => 'anyone',

            ],
            [
                'id' => 5,
                'name' => 'Comandos Con Parametros',
                'command' => 'cualqier comando agregar...',
                'code' => 'anyoneParams',

            ],
        ];
        return $mikrotiksManagerEvent;
    }

    public function searchData($params)
    {
        $util = new \App\Utils\Util;

        return $util::searchInArray($params);

    }


}

?>
