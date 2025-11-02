<?php

namespace App\Constants;
use App\Utils\Util;
use Auth;

class CrugeConstants
{
    //constantes para ROLEs
    const USUARIOS_ADMINISTRADOR_TOTAL = "ADMINISTRADOR_TOTAL"; //1
    const USUARIOS_ADMINISTRADOR_LOCAL = "ADMINISTRADOR_LOCALES"; //2
    const USUARIOS_VENDEDOR = "VENDEDORES"; //3
    const USUARIOS_CLIENTES = "CLIENTES"; //3
    const USUARIOS_REGISTER = "USUARIOS_REGISTRADOS"; //3
    const urlGoogleMaps = "https://maps.googleapis.com/maps/api/js?sensor=true&language=es"; //NULL
    const admin = "admin";
    const guest = "guest";
    const admin_rol = '';

    /*----ROLES XYWER-----*/
    const ROLE_BUYS = "ROL_COMPRAS";
    const ROLE_ACCOUNTING_FINANCE = "ROL_FINANZASCONTABILIDAD";
    const ROLE_SALES = "ROL_VENDEDOR";
    const ROLE_HUMAN_RESOURCES = "ROL_RECURSOSHUMANOS";
    const ROLE_MANAGEMENT = "ROL_GERENCIA";
    const ROLE_ADMINISTRATION = "ROL_ADMINISTRADOR";

    public $urlLoginEmployer='';
    public function __construct(array $attributes = [])
    {

        $this->urlLoginEmployer = route('dashboardManager');


    }



}
