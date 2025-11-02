<?php

namespace App\Models\MikrotikManager;
use Auth;
use App\Utils\Mikrotik\MikrotickManager;
use App\Utils\Mikrotik\RouterosAPICustom;

class Mikrotik
{
    public function getManagerEventResults($params)
    {
        $dataCurrrentManager = $params['MikrotikManagerEvents'];
        $typeEvent = $dataCurrrentManager['type_event'];
        $mikrotik_code = $dataCurrrentManager['mikrotik_code'];
        $mikrotik = $dataCurrrentManager['mikrotik'];
        $API = new RouterosAPICustom();
        $mm = new MikrotickManager();
        $API->debug = false;
        $all = [];
        $success = false;
        $resultSearch = $mm->searchData([
            'haystack' => $mm->mikrotiksManager,
            'needle' => $mikrotik,
            'keyCompare' => 'id'

        ]);
        $currentMikotik = [];
        $msg = '';
        $data = [];
        if (count($resultSearch)) {
            $resultSearchEvents = $mm->searchData([
                'haystack' => $mm->getEventsManager(),
                'needle' => $typeEvent,
                'keyCompare' => 'id'

            ]);

            if (count($resultSearchEvents)) {
                $typeEventCurrent = $resultSearchEvents['0']['value'];
                $typeEventCode = $typeEventCurrent['code'];
                $currentMikotik = $resultSearch['0']['value'];
                if ($API->connect($currentMikotik['ip'], $currentMikotik['user'], $currentMikotik['password'])) {
                    $resultCommands = $API->getResultsByCommands([
                        'typeEventCode' => $typeEventCode,
'mikrotik_code'=>$mikrotik_code
                    ]);
                    $success = $resultCommands['success'];
                    $msg = $resultCommands['message'];

                    if ($success) {
                        $data = $resultCommands['data'];
                    }
                    $API->disconnect();

                } else {
                    $msg = 'No se ha podido conectarse al mikrotik';
                }
            } else {

            }


        } else {
            $msg = 'No existe Mikrotik';
        }

        $result = [
            'success' => $success,
            'msg' => $msg,
            'message' => $msg,
            'data' => $data,

        ];
        return $result;

    }


}
