<?php
/*****************************
 *
 * RouterOS PHP API class v1.6
 * Author: Denis Basta
 * Contributors:
 *    Nick Barnes
 *    Ben Menking (ben [at] infotechsc [dot] com)
 *    Jeremy Jefferson (http://jeremyj.com)
 *    Cristian Deluxe (djcristiandeluxe [at] gmail [dot] com)
 *    Mikhail Moskalev (mmv.rus [at] gmail [dot] com)
 *
 * http://www.mikrotik.com
 * http://wiki.mikrotik.com/wiki/API_PHP_class
 *
 ******************************/

namespace App\Utils\Mikrotik;

use  App\Utils\Mikrotik\RouterosAPI;

class RouterosAPICustom extends RouterosAPI
{
    const COMMAND_INTERFACES = '/interface/ethernet/getall';
    const COMMAND_HEALTH = 'HEALTH';
    const COMMAND_STATE_USERS = 'stateUsers';
    const COMMAND_ANYONE = 'anyone';
    const COMMAND_ANYONE_PARAMS = 'anyoneParams';
    public $apiInit = null;
    public $keysTextAllow = [
        '=comment=', '=mac-address=', '=list=', '-address-', '?address='

    ];

    public function sanear_string($string)
    {

        $string = trim($string);

        $string = str_replace(
            array('<', '>',),
            array('', '',),
            $string
        );
        return $string;
    }

    public function sanear_mac($mac)
    {
        $mac = trim($mac);

        $mac = str_replace(
            array('', '0.0.0.0', 'null'),
            array('00:00:00:00:00:00', '00:00:00:00:00:00', '00:00:00:00:00:00'),
            $mac
        );
        return $mac;
    }

    public function segmento($segmento_comercial)
    {
        if ($segmento_comercial == "8/8" || $segmento_comercial == "7/7") {
            $segmento_comercial = "Residencial";
        } else if ($segmento_comercial == "6/6") {
            $segmento_comercial = "Comercial";
        } else if ($segmento_comercial == "4/4" || $segmento_comercial == "3/3") {
            $segmento_comercial = "Corporativo";
        } else if ($segmento_comercial == "2/2") {
            $segmento_comercial = "Pruebas o Bloqueos";
        } else if ($segmento_comercial == "1/1") {
            $segmento_comercial = "Dedicado";
        }
        return $segmento_comercial;
    }

    public function bandwith($ancho_banda)
    {

        $ancho_banda = str_replace(
            array('/'),
            array('</span>/<span class="DownloadAsignado">'),
            $ancho_banda
        );
        return $ancho_banda;
    }


    public function getResultsByCommands($params)
    {
        $API = $this;
        $success = false;
        $html = '';
        $message = 'Error al obtener la informacion.';
        $data = [];
        $typeEventCode = $params['typeEventCode'];
        switch ($typeEventCode) {
            case self::COMMAND_INTERFACES:
                $success = true;
                $html = '<div class="table-responsive">';
                $html .= '<table class="table table-bordered table-striped">';
                $html .= '<thead>';
                $html .= '<tr>';
                $html .= ' <th width="50%">Nombre Interfaz</th>';
                $html .= '<th width="20%">Estado</th>';
                $html .= ' <th width="30%">Velocidad LAN</th>';
                $html .= ' </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';

                $this->write("/interface/ethernet/getall", true);
                $READ = $this->read(false);
                $ARRAY = $this->parse_response($READ);
                if (count($ARRAY) > 0) {   // si hay mas de 1 queue.
                    for ($x = 0; $x < count($ARRAY); $x++) {
                        $name = $this->sanear_string($ARRAY[$x]['name']);
                        $speed = $this->sanear_string($ARRAY[$x]['speed']);
                        if ($ARRAY[$x]['running'] == "true") {
                            $estado = "<span class='ok'>conectado</span>";
                        } else {
                            $estado = "<span class='fail'>desconectado</span>";
                        }
                        $datos_interface = '<tr>';
                        $datos_interface .= '<td>' . $name . '</td>';
                        $datos_interface .= '<td>' . $estado . '</td>';
                        $datos_interface .= '<td>' . $speed . '</td>';
                        $datos_interface .= '</tr>';
                        $html .= $datos_interface;

                    }
                } else { // si no hay ningun binding

                    $html .= "<tr><td colspan='3'>  No hay ningun IP-Bindings</td></tr>";

                }

                $html .= '  </tbody>';
                $html .= ' </table>';
                $html .= '  </div>';
                $data = [
                    'html' => $html
                ];
                $message = 'Informacion obtenida con exito.';

                break;
            case  self::COMMAND_STATE_USERS:
                $success = true;
                $html .= '  <div class="table-responsive">';
                $html .= '<table class="table table-bordered table-striped">';
                $html .= ' <thead>';
                $html .= ' <tr>';
                $html .= '<th width="50%">Item</th>';
                $html .= ' <th width="50%">Valor</th>';
                $html .= ' </tr>';
                $html .= ' </thead>';
                $html .= ' <tbody>';
                $html .= ' <tr>';
                $html .= ' <td>Nombre Equipo</td>';
                $this->write("/system/identity/getall", true);
                $READ = $this->read(false);
                $ARRAY = $this->parse_response($READ);
                if (count($ARRAY) > 0) {   // si hay mas de 1 queue.
                    for ($x = 0; $x < count($ARRAY); $x++) {
                        $datos_interface = '<td>' . $ARRAY[$x]['name'] . '</td>';
                        $html .= $datos_interface;
                        //var_dump($ARRAY);
                    }
                } else { // si no hay ningun binding

                    $html .= "<td >  No hay ningun IP-Bindings</td>";

                }

                $html .= '  </tr>';
                $html .= '   <tr>';
                $html .= '<td>Temperatura Mikrotik</td>';

                $this->write("/system/health/getall", true);
                $READ = $this->read(false);
                $ARRAY = $this->parse_response($READ);
                if (count($ARRAY) > 0) {   // si hay mas de 1 queue.
                    for ($x = 0; $x < count($ARRAY); $x++) {

                        if ($ARRAY[$x] != null) {

                            $temperature = ($ARRAY[$x]['temperature']);
                            if ($temperature >= "56") {
                                $temperatura = "<span class='fail'>" . $temperature . "&ordm;C</span>";
                            } else {
                                $temperatura = "<span class='ok'>" . $temperature . "&ordm;C</span>";
                            }
                            $datos_interface = '<td>' . $temperatura . '</td>';
                            $html .= $datos_interface;
                        } else {
                            $temperatura = "<span class='not-exist'>No existe temperatura</span>";
                            $datos_interface = '<td>' . $temperatura . '</td>';
                            $html .= $datos_interface;

                        }

                    }
                } else { // si no hay ningun binding


                    $temperatura = "<span class='not-exist'>No hay ningun IP-Bindings</span>";
                    $datos_interface = '<td>' . $temperatura . '</td>';
                    $html .= $datos_interface;
                }

                $html .= '</tr > ';

                $this->write("/system/routerboard/getall", true);
                $READ = $this->read(false);
                $ARRAY = $this->parse_response($READ);
                if (count($ARRAY) > 0) {   // si hay mas de 1 queue.
                    for ($x = 0; $x < count($ARRAY); $x++) {

                        $datos_routerboard = '<tr > ';
                        $datos_routerboard .= '<td > Serial</td > ';
                        $datos_routerboard .= '<td > ' . $ARRAY[$x]['serial-number'] . ' </td > ';
                        $datos_routerboard .= '</tr > ';
                        $datos_routerboard = '<tr > ';
                        $datos_routerboard .= '<td > Modelo</td > ';
                        $datos_routerboard .= '<td > RB ' . $ARRAY[$x]['model'] . ' </td > ';
                        $datos_routerboard .= '</tr > ';
                        $html .= $datos_routerboard;
                        //var_dump($ARRAY);
                    }
                } else { // si no hay ningun binding
                    $html .= "No hay ningun IP-Bindings. //<br/>";
                }

                $this->write("/system/resource/getall", true);
                $READ = $this->read(false);
                $ARRAY = $this->parse_response($READ);
                if (count($ARRAY) > 0) {   // si hay mas de 1 queue.
                    for ($x = 0; $x < count($ARRAY); $x++) {
                        if (!empty($ARRAY[$x]['bad-blocks']) == "") {
                            $bad_blocks = "<span class='fail'>No Aplica para esta versi&oacute;n de Mikrotik</span>";
                        } else if ($ARRAY[$x]['bad-blocks'] >= "6") {
                            $bad_blocks = ("<span class='fail'>" . $ARRAY[$x]['bad-blocks'] . "</span>");
                        } else {
                            $bad_blocks = ("<span class='ok'>" . $ARRAY[$x]['bad-blocks'] . "</span>");
                        }
                        $datos_resource = ' < tr>';
                        $datos_resource .= ' < td>Uso CPU </td > ';
                        $datos_resource .= '<td > ' . $ARRAY[$x]['cpu-load'] . ' </td > ';
                        $datos_resource .= '</tr > ';
                        $datos_resource = '<tr > ';
                        $datos_resource .= '<td > Bloques dañados </td > ';
                        $datos_resource .= '<td > ' . $bad_blocks . '</td > ';
                        $datos_resource .= '</tr > ';
                        $html .= $datos_resource;
                        //var_dump($ARRAY);
                    }
                } else { // si no hay ningun binding
                    $html .= "No hay ningun IP-Bindings. //<br/>";
                }

                $html .= '</tbody>';
                $html .= ' </table > ';
                $html .= '</div>';

                $data = [
                    'html' => $html
                ];
                $message = 'Informacion obtenida con exito.';

                break;
            case self::COMMAND_HEALTH:

                $success = true;
                $html .= '<div class="content">';
                $html .= '<h2 class="content-subhead">Información General</h2>';
                $html .= '<p>';
                $html .= '  <div class="table-responsive">';
                $html .= '<table class="table table-bordered table-striped">';
                $html .= ' <thead>';
                $html .= '<tr>';
                $html .= ' <th>Nombre Cliente</th>';
                $html .= '<th>MAC CPE</th>';
                $html .= ' <th>IP</th>';
                $html .= '<th>Tiempo Conexi&oacute;n</th>';
                $html .= '</tr>';
                $html .= ' </thead>';

                $html .= '<tbody>';

                $this->write("/ppp/active/getall", true);
                $READ = $this->read(false);
                $ARRAY = $this->parse_response($READ);
                if (count($ARRAY) > 0) {   // si hay mas de 1 queue.
                    for ($x = 0; $x < count($ARRAY); $x++) {

                        $name = sanear_string($ARRAY[$x]['name']);
                        $datos_pppoe = '<tr>';
                        $datos_pppoe .= '<td>' . $name . '</td>';
                        $datos_pppoe .= '<td>' . $ARRAY[$x]['caller-id'] . '</td>';
                        $datos_pppoe .= '<td>' . $ARRAY[$x]['address'] . '</td>';
                        $datos_pppoe .= '<td>' . $ARRAY[$x]['uptime'] . '</td>';
                        $datos_pppoe .= '</tr>';
                        $html .= $datos_pppoe;
                    }
                } else { // si no hay ningun binding
                    $html .= "<tr><td>  No hay ningun IP-Bindings.</td><td></td><td></td><td></td> </tr>";
                }

                $html .= '  </tbody>';
                $html .= '</table>';
                $html .= ' </div>';

                $html .= ' </div>';
                $data = [
                    'html' => $html
                ];
                $message = 'Informacion obtenida con exito.';

                break;
            case self::COMMAND_ANYONE:

                $success = true;
                $html .= '<div class="content">';
                $html .= '<h2 class="content-subhead">Información General</h2>';
                $html .= '  <div class="table-responsive">';
                $mikrotik_code = $params['mikrotik_code'];
                $READ = [];
                $ARRAY = [];
                $arrayResponse = [];
                $ARRAY = $this->comm($mikrotik_code);
                $html .= $this->generateDynamicTable(['haystack' => $ARRAY]);


                $html .= ' </div>';

                $html .= ' </div>';
                $data = [
                    'html' => $html,
                    'READ' => $READ,
                    'ARRAY' => $ARRAY,
                    'response' => $arrayResponse

                ];
                $message = 'Informacion obtenida con exito.';

                break;
            case self::COMMAND_ANYONE_PARAMS:

                $success = true;

                $mikrotik_code_manager = $params['mikrotik_code'];
                $mikrotik_code_items = explode(";", $mikrotik_code_manager);

                $countData = count($mikrotik_code_items);
                $html .= '<div class="content">';
                $html .= '<h2 class="content-subhead">Información General</h2>';
                $html .= '  <div class="table-responsive">';

                $READ = [];
                $ARRAY = [];
                $arrayResponse = [];
                if ($countData >= 1) {
                    $mikrotik_code = $mikrotik_code_items['0'];
                    $typeGenerate = 1;

                    if ($typeGenerate == 1) {
                        $paramsCurrentManagerMikrotikManager = $this->getArrayFormatParams(
                            [
                                'mikrotik_code_items' => $mikrotik_code_items,
                                'typeGenerate' => $typeGenerate
                            ]
                        );
                        $paramsCurrentManagerMikrotik = $paramsCurrentManagerMikrotikManager['params'];
                        $functionName = $paramsCurrentManagerMikrotikManager['functionNameLast'];

                        if ($functionName != 'remove') {
                            $allowParams = count($paramsCurrentManagerMikrotik) == 0 ? true : false;
                            $this->write($mikrotik_code, $allowParams);
                            foreach ($paramsCurrentManagerMikrotik as $key => $value) {
                                foreach ($value as $keyName => $valueParams) {
                                    $valueCurrent = $keyName . $valueParams;
                                    $allowParam = false;
                                    if (in_array($keyName, $this->keysTextAllow)) {
                                        $allowParam = true;

                                    }

                                    $this->write($valueCurrent, $allowParam);
                                }
                            }
                            $READ = $this->read(false);
                            $ARRAY = $this->parse_response($READ);
                        } else {
                            $newComm = $paramsCurrentManagerMikrotikManager['functionNameAllTypeEnd'] . 'getall';
                            if (false) {
                                $this->write($newComm, false);
                                foreach ($paramsCurrentManagerMikrotik as $key => $value) {
                                    foreach ($value as $keyName => $valueParams) {
                                        $valueCurrent = $keyName . $valueParams;
                                        $allowParam = false;
                                        if (in_array($keyName, $this->keysTextAllow)) {
                                            $allowParam = true;

                                        }

                                        $this->write($valueCurrent, $allowParam);
                                    }
                                }
                            } else if (false) {

                                $this->write($newComm, false);
                                foreach ($paramsCurrentManagerMikrotik as $key => $value) {
                                    foreach ($value as $keyName => $valueParams) {
                                        $valueCurrent = $keyName . $valueParams;
                                        $allowParam = false;
                                        if (in_array($keyName, $this->keysTextAllow)) {
                                            $allowParam = true;

                                        }
                                        var_dump($keyName);
                                        $this->write($valueCurrent, $allowParam);
                                    }
                                }
                                dd(69);
                                $READView = $this->read(false);
                                $ARRAYView = $this->parse_response($READView);
                                if (count($ARRAYView) > 0) {
                                    $ID = $ARRAYView[0]['.id'];
                                    $API->write($mikrotik_code, false);
                                    $API->write('=.id=' . $ID, true);


                                } else { // si no existe lo creo
                                    $msgError = 'No existe esta ip';
                                    $html .= '  <div class="table-responsive__empty">';
                                    $html .= '    <h3>' . $msgError . '</h3>';

                                    $html .= '  </div>';
                                }
                            } else {


                                $this->write($newComm, false);
                                foreach ($paramsCurrentManagerMikrotik as $key => $value) {
                                    foreach ($value as $keyName => $valueParams) {
                                        $valueCurrent = $keyName . $valueParams;
                                        $allowParam = false;
                                        if (in_array($keyName, $this->keysTextAllow)) {
                                            $allowParam = true;
                                        }
                                        $this->write($valueCurrent, $allowParam);
                                    }
                                }

                                $READ = $this->read(false);
                                $ARRAYView = $this->parse_response($READ);

                                if (count($ARRAYView) > 0) {
                                    $ID = $ARRAYView[0]['.id'];

                                    $API->write($mikrotik_code, false);
                                    $API->write('=.id=' . $ID, true);
                                    $READ = $this->read(false);
                                    $ARRAY= $this->parse_response($READ);


                                } else { // si no existe lo creo
                                    $msgError = 'No existe esta ip';
                                    $html .= '  <div class="table-responsive__empty">';
                                    $html .= '    <h3>' . $msgError . '</h3>';

                                    $html .= '  </div>';
                                }
                            }


                        }

                    } else if ($typeGenerate == 2) {
                        //https://1coder.ir/402/api-mikrotik-crear-queues-simples-con-php-con-validacion/
                        $target = "192.168.0.5";  // IP Cliente
                        $name = "nicolas222";
                        $maxlimit = "5M/5M";
                        $comment = "Este es un ejemplo.";
                        $managerAttribute = $this->getByAttribute([
                            'commandInit' => "/queue/simple/getall",
                            'commandKey' => '?name=' . $name,
                            'commandKeyType' => true
                        ]);
                        $ARRAY = $managerAttribute['ARRAY'];
                        if (count($ARRAY) == 0) {
                            $API->write("/queue/simple/add", false);
                            $API->write('=target=' . $target, false);   // IP
                            $API->write('=name=' . $name, false);       // nombre
                            $API->write('=max-limit=' . $maxlimit, false);   //   2M/2M   [TX/RX]
                            $API->write('=comment=' . $comment, true);         // comentario
                            $READ = $API->read(false);
                            $ARRAY = $API->parse_response($READ);

                        } else {
                            $maxlimit = "20M/20M";
                            $name = 'panchito-cambiado';
                            $API->write("/queue/simple/set", false);
                            $API->write("=.id=" . $ARRAY[0]['.id'], false);
                            $API->write('=name=' . $name, false);       // nombre
                            $API->write('=max-limit=' . $maxlimit, true);   //   2M/2M   [TX/RX]

                            //   2M/2M   [TX/RX]
                            $READ = $API->read(false);
                            $ARRAY = $API->parse_response($READ);

                            $msgError = 'Este usuario ya se ha creado internamente :' . $name;
                            $html .= '  <div class="table-responsive__empty">';
                            $html .= '    <h3>' . $msgError . '</h3>';

                            $html .= '  </div>';
                        }

                    } else if ($typeGenerate == 3) {
                        //https://1coder.ir/402/api-mikrotik-crear-queues-simples-con-php-con-validacion/
                        $name = "nicolas222";
                        $managerAttribute = $this->getByAttribute([
                            'commandInit' => "/queue/simple/getall",
                            'commandKey' => '?name=' . $name,
                            'commandKeyType' => true
                        ]);
                        $READ = $managerAttribute['READ'];
                        $ARRAY = $managerAttribute['ARRAY'];

                    } else if ($typeGenerate == 69) {
                        $address = '192.168.0.42';
                        $macaddress = '34:17:EB:CF:BC:80';
                        $comment = "PC OF ALEX";
                        $rateLimit = '20M/20M';
                        $server = 'dhcp1';
                        $disabled = 'no';

                        $API->write("/ip/dhcp-server/lease/add", false);
                        $API->write('=address=' . $address, false);       // nombre
                        $API->write('=mac-address=' . $macaddress, false);       // nombre
                        $API->write('=comment=' . $comment, true);       // nombre
                        $API->write('=rate-limit=' . $rateLimit, false);       // nombre
                        $API->write('=server=' . $server, false);       // nombre
                        $API->write('=disabled=' . $disabled, false);   //   2M/2M   [TX/RX]

                        //   2M/2M   [TX/RX]
                        $READ = $API->read(false);
                        $ARRAY = $API->parse_response($READ);

                    } else if ($typeGenerate == 70) {
                        $address = '192.168.0.92';
                        $list = 'BlockLeaseIPs';

                        $API->write("/ip/firewall/address-list/add", false);
                        $API->write('=address=' . $address, false);       // nombre
                        $API->write('=list=' . $list, true);       // nombre
                        //   2M/2M   [TX/RX]
                        $READ = $API->read(false);
                        $ARRAY = $API->parse_response($READ);

                    } else if ($typeGenerate == 71) {
                        $address = '192.168.0.101';
                        $list = 'BlockLeaseIPs';


                        $API->write("/ip/firewall/address-list/remove", false);
                        $API->write('=address=' . $address, false);
                        //   2M/2M   [TX/RX]
                        $READ = $API->read(false);
                        $ARRAY = $API->parse_response($READ);

                    }

                    $html .= $this->generateDynamicTable(['haystack' => $ARRAY]);

                } else {
                    $msgError = 'Esta enviando mal la informacion para la ejecucion del comando.';
                    $html .= '  <div class="table-responsive__empty">';
                    $html .= '    <h3>' . $msgError . '</h3>';

                    $html .= '  </div>';

                }

                $html .= ' </div>';
                $html .= ' </div>';
                $data = [
                    'html' => $html,
                    'READ' => $READ,
                    'ARRAY' => $ARRAY,
                    'response' => $arrayResponse

                ];
                $message = 'Informacion obtenida con exito.';

                break;
        }
        $result = [
            'success' => $success,
            'data' => $data,
            'message' => $message,

        ];


        return $result;
    }

    public function getByAttribute($params)
    {
        $commandInit = $params['commandInit'];
        $commandKey = $params['commandKey'];
        $typeCommand = isset($params['typeCommand']) ? $params['typeCommand'] : 0;
        $commandKeyType = isset($params['commandKeyType']) ? $params['commandKeyType'] : false;
        $ARRAY = [];
        if ($typeCommand == 0) {
            $this->write($commandInit, false);
            $this->write($commandKey, $commandKeyType);
            $READ = $this->read(false);
            $ARRAY = $this->parse_response($READ);
        } else if ($typeCommand == 1) {

        }

        return [
            'ARRAY' => $ARRAY,
            'READ' => $READ,

        ];
    }

    public function generateDynamicTable($params)
    {
        $haystack = $params['haystack'];

        //generate columns header
        $html = '<table class="table table-bordered table-striped">';
        if (isset($haystack['!trap']) == false) {
            if (is_array($haystack)) {
                $countHaystack = count($haystack);
                if ($countHaystack == 0) {
                    $html .= ' <thead>';
                    $html .= '<tr>';
                    $html .= ' <th>Informacion</th>';
                    $html .= '</tr>';
                    $html .= ' </thead>';
                    $html .= ' <tbody>';
                    $html .= ' <tr>';
                    $html .= ' <th>' . 'No existe informacion';
                    $html .= ' <th>';
                    $html .= ' </tr>';
                    $html .= ' </tbody>';

                } else {
                    $html .= ' <thead>';
                    $html .= ' <tr>';

                    $haystackRowCol = $haystack['0'];
                    $colsName = [];
                    foreach ($haystackRowCol as $key => $row) {
                        $colsName  [] = $key;
                        $html .= ' <th>';
                        $html .= $key;
                        $html .= ' </th>';


                    }
                    $html .= ' </tr>';
                    $html .= ' </thead>';
                    $html .= ' <tbody>';
                    foreach ($haystack as $key => $row) {
                        $haystackCols = $row;

                        $html .= ' <tr>';
                        foreach ($colsName as $keyCol => $col) {
                            $html .= ' <th>';
                            if (isset($haystackCols[$col])) {
                                $html .= $haystackCols[$col];
                            } else {
                                $html .= 'None';
                            }
                            $html .= ' </th>';
                        }
                        $html .= ' </tr>';
                    }
                    $html .= ' </tbody>';
                }
            } else {
                $html .= ' <thead>';
                $html .= '<tr>';
                $html .= ' <th>Informacion</th>';
                $html .= '</tr>';
                $html .= ' </thead>';
                $html .= ' <tbody>';
                $html .= ' <tr>';
                $html .= ' <th>' . 'Ok informacion gestionada ' . $haystack;
                $html .= ' <th>';
                $html .= ' </tr>';
                $html .= ' </tbody>';
            }

        } else {
            $dataRows = $haystack['!trap'];


            $html .= ' <thead>';
            $html .= '<tr>';
            $html .= ' <th>Informacion</th>';
            $html .= '</tr>';
            $html .= ' </thead>';
            $html .= ' <tbody>';
            $html .= ' <tr>';
            foreach ($dataRows as $key => $row) {
                foreach ($row as $keyCol => $col) {
                    $html .= ' <th>' . $col;
                    $html .= ' </th>';
                }
            }

            $html .= ' </tr>';
            $html .= ' </tbody>';
        }

        $html .= '</table>';

        return $html;

    }

    /*  OTHER FUNCTIONS ROUTES*/
    public function parse_response($response)
    {
        if (is_array($response)) {
            $PARSED = array();
            $CURRENT = null;
            $singlevalue = null;
            foreach ($response as $x) {
                if (in_array($x, array(
                    '!fatal',
                    '!re',
                    '!trap'
                ))) {
                    if ($x == '!re') {
                        $CURRENT =& $PARSED[];
                    } else
                        $CURRENT =& $PARSED[$x][];
                } else if ($x != '!done') {
                    $MATCHES = array();
                    if (preg_match_all('/[^=]+/i', $x, $MATCHES)) {
                        if ($MATCHES[0][0] == 'ret') {
                            $singlevalue = $MATCHES[0][1];
                        }
                        $CURRENT[$MATCHES[0][0]] = (isset($MATCHES[0][1]) ? $MATCHES[0][1] : '');
                    }
                }
            }
            if (empty($PARSED) && !is_null($singlevalue)) {
                $PARSED = $singlevalue;
            }
            return $PARSED;
        } else
            return array();
    }

    public function getArrayFormatParams($params)
    {
        $mikrotik_code_items = $params['mikrotik_code_items'];
        $typeGenerate = $params['typeGenerate'];

        $mikrotik_code = $mikrotik_code_items['0'];
        $crudeType = '?';//this view
        $crudeTypeItems = explode('/', $mikrotik_code);
        $crudeTypeItemsCount = count($crudeTypeItems);
        $lastCode = isset($crudeTypeItems[$crudeTypeItemsCount - 1]) ? trim($crudeTypeItems[$crudeTypeItemsCount - 1]) : null;
        $countCommand = count($crudeTypeItems);
        $countCommandAux = 0;
        $functionNameList = $crudeTypeItems;
        $functionNameAllTypeEnd = '';

        foreach ($crudeTypeItems as $keyName => $value) {
            if ($countCommandAux < $countCommand - 1) {
                if ($countCommandAux < $countCommand - 1) {
                    $functionNameAllTypeEnd .= $value . '/';
                } else {
                    $functionNameAllTypeEnd .= $value;

                }
            }


            $countCommandAux++;
        }
        $paramsCurrentManagerMikrotik = [];
        if (isset($mikrotik_code_items['1'])) {
            $mikrotik_code_params_items = explode(',', $mikrotik_code_items['1']);
            foreach ($mikrotik_code_params_items as $keyName => $value) {
                $keyNameValueItem = explode('=', $value);
                $keyCurrent = trim($keyNameValueItem[0]);
                $valueCurrent = $keyNameValueItem[1];
                $concatParams = '';
                $keyNameCurrent = '';
                if ($typeGenerate == 1) {

                    if ($lastCode == 'add') {
                        $keyNameCurrent = '=' . $keyCurrent . '=';
                    } else if ($lastCode == 'set') {
                        $keyNameCurrent = '=' . $keyCurrent . '=';
                    } else if ($lastCode == 'getall') {
                        $keyNameCurrent = '?' . $keyCurrent . '=';
                    } else if ($lastCode == 'print') {
                        $keyNameCurrent = '?' . $keyCurrent . '=';
                    } else if ($lastCode == 'remove') {
                        $keyNameCurrent = '?' . $keyCurrent . '=';
                    }
                } else {

                }
                $paramsCurrentManagerMikrotik[] = [$keyNameCurrent => $valueCurrent];
            }
        }

        $result = [
            'params' => $paramsCurrentManagerMikrotik,
            'functionNameLast' => $lastCode,
            'functionNameList' => $functionNameList,
            'functionNameAllTypeEnd' => $functionNameAllTypeEnd,


        ];

        return $result;

    }
}
