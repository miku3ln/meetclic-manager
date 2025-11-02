<?php

namespace App\Utils;

use App\Utils\Util;
use Auth;
use App\Models\InformationPhoneType;
use App\Models\InformationPhoneOperator;
use App\Models\InformationMailType;
use App\Models\InformationSocialNetworkType;


use App\Models\InformationAddress as InformationAddress;

class BusinessManager
{


    public static function getDataManager($params)
    {
        $result = [];
        $header = self::getHeaderHtml($params);
        $result['content']['headerHtml'] = $header;

        return $result;
    }

    public static function getDataManagerDefault()
    {
        $result = [
            'information_phone_type' => null,
            'information_phone_type_personal_phone' => null,

            'information_phone_operator' => null,


            'information_mail_type' => null,
            'information_social_network_type' => null];
        $phoneOperator = new InformationPhoneOperator();
        $phoneType = new InformationPhoneType();
        $information_phone_operatorData = $phoneOperator->getDataById(['id' => InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID]);
        if (count($information_phone_operatorData) > 0) {
            $result['information_phone_operator'] = $information_phone_operatorData['0'];
        }
        $information_phone_typeData = $phoneType->getDataById(['id' => InformationPhoneType::TYPE_NOT_SPECIFIC_ID]);
        if (count($information_phone_typeData) > 0) {
            $result['information_phone_type'] = $information_phone_typeData['0'];
        }
        $information_phone_typeData = $phoneType->getDataById(['id' => InformationPhoneType::TYPE_PERSONAL_PHONE_ID]);
        if (count($information_phone_typeData) > 0) {
            $result['information_phone_type_personal_phone'] = $information_phone_typeData['0'];
        }
        $mailType = new InformationMailType();
        $information_mail_typeData = $mailType->getDataById(['id' => InformationMailType::TYPE_NOT_SPECIFIC_ID]);
        if (count($information_mail_typeData) > 0) {
            $result['information_mail_type'] = $information_mail_typeData['0'];
        }

        $socialNetworkType = new InformationSocialNetworkType();
        $information_social_network_typeData = $socialNetworkType->getDataById(['id' => InformationSocialNetworkType::TYPE_NOT_SPECIFIC_ID]);
        if (count($information_social_network_typeData) > 0) {
            $result['information_social_network_type'] = $information_social_network_typeData['0'];
        }
        return $result;
    }

    public static function getHeaderHtml($params)
    {
        $business = isset($params['modelDataManager']['business'][0]) ? $params['modelDataManager']['business'][0] : [];

        $paramsCurrent = [
            'title-left' => 'Administracion',
            'titles-right' => [
                ['title' => 'Dashboard', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => 'managerDashboard']), 'active' => true],

            ]
        ];

        $typeManager = $params['typeManager'];
        switch ($typeManager) {
            case 'managerBusinessByLanguage':
                $titlesRight = [
                    ['title' => 'Empresa', 'active' => false],
                    ['title' => 'Idiomas', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerTaxByBusiness':
                $titlesRight = [
                    ['title' => 'Empresa', 'active' => false],
                    ['title' => 'Iva', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerGallery':
                $titlesRight = [
                    ['title' => 'Empresa', 'active' => false],
                    ['title' => 'Galeria Empresa', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerBusinessBySchedule':
                $titlesRight = [
                    ['title' => 'Empresa', 'active' => false],
                    ['title' => 'Horarios', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerBusinessByHistory':
                $titlesRight = [
                    ['title' => 'Empresa', 'active' => false],
                    ['title' => 'Historia', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerBusinessByInformationCustom':
                $titlesRight = [
                    ['title' => 'Empresa', 'active' => false],
                    ['title' => 'Mision/Vision', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerBusinessCounterCustom':
                $titlesRight = [
                    ['title' => 'Empresa', 'active' => false],
                    ['title' => 'Counters', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerBusinessByPartnerCompanies':
                $titlesRight = [
                    ['title' => 'Empresa', 'active' => false],
                    ['title' => 'Empresas Alidadas', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerHumanResourcesDepartment':
                $titlesRight = [
                    ['title' => 'RRHH', 'active' => false],
                    ['title' => 'Departamentos', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerHumanResourcesEmployeeProfile':
                $titlesRight = [
                    ['title' => 'RRHH', 'active' => false],
                    ['title' => 'Personal', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerCustomer':
                $titlesRight = [
                    ['title' => 'CRM', 'active' => false],
                    ['title' => 'Clientes', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerMailingTemplate':
                $titlesRight = [
                    ['title' => 'Marketing', 'active' => false],
                    ['title' => 'Plantillas', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerGamificationTypeActivity':
                $titlesRight = [
                    ['title' => 'Gamificacion', 'active' => false],
                    ['title' => 'Tipos de Actividad', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerBusinessByGamification':
                $titlesRight = [
                    ['title' => 'Gamificacion', 'active' => false],
                    ['title' => 'Administracion', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerRoutes':
                $titlesRight = [
                    ['title' => 'Rutas-Mapas', 'active' => false],
                    ['title' => 'Chakiñanes', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerPanorama':
                $titlesRight = [
                    ['title' => 'Rutas-Mapas', 'active' => false],
                    ['title' => 'Galeria Chakiñanes', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerProduct':
                $titlesRight = [
                    ['title' => 'Tienda', 'active' => false],
                    ['title' => 'Productos', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerBusinessByDiscount':
                $titlesRight = [
                    ['title' => 'Tienda', 'active' => false],
                    ['title' => 'Desc. Productos', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerProductService':
                $titlesRight = [
                    ['title' => 'Tienda', 'active' => false],
                    ['title' => 'Servicios', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerBusinessByShippingRate':
                $titlesRight = [
                    ['title' => 'Tienda', 'active' => false],
                    ['title' => 'Configuracion Envio', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerOrderPaymentsManager':
                $titlesRight = [
                    ['title' => 'Tienda', 'active' => false],
                    ['title' => 'Eccomerce', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerTemplateInformation':
                $titlesRight = [
                    ['title' => 'Pagina Web', 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerRepairProductByBusiness':
                $titlesRight = [
                    ['title' => 'Gestion Reparacion', 'active' => false],
                    ['title' => 'Partes / Otros', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerRepair':
                $titlesRight = [
                    ['title' => 'Gestion Reparacion', 'active' => false],
                    ['title' => 'Reparaciones', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerAllergies':
                $titlesRight = [
                    ['title' => 'Hospital/Clinica', 'active' => false],
                    ['title' => 'Alergias', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerHabits':
                $titlesRight = [
                    ['title' => 'Hospital/Clinica', 'active' => false],
                    ['title' => 'Habitos', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerPatient':
                $titlesRight = [
                    ['title' => 'Hospital/Clinica', 'active' => false],
                    ['title' => 'Pacientes', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerLodgingTypeOfRoom':
                $titlesRight = [
                    ['title' => 'Hoteleria', 'active' => false],
                    ['title' => 'Tipos de Habitaciones', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerLodgingRoomLevels':
                $titlesRight = [
                    ['title' => 'Hoteleria', 'active' => false],
                    ['title' => 'Niveles de Habitacion', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerLodgingRoomFeatures':
                $titlesRight = [
                    ['title' => 'Hoteleria', 'active' => false],
                    ['title' => 'Caracteristicas Habitacion', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerLodgingTypeOfRoomByPrice':
                $titlesRight = [
                    ['title' => 'Hoteleria', 'active' => false],
                    ['title' => 'Habitaciones', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerLodgingStatisticalData':
                $titlesRight = [
                    ['title' => 'Hoteleria', 'active' => false],
                    ['title' => 'Reportes Estadisticos', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerLodging':
                $titlesRight = [
                    ['title' => 'Hoteleria', 'active' => false],
                    ['title' => 'Recepcion', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerEducationalInstitutionAskwerType':
                $titlesRight = [
                    ['title' => 'Gestion Formularios', 'active' => false],
                    ['title' => 'Tipos', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerEducationalInstitutionByBusiness':
                $titlesRight = [
                    ['title' => 'Gestion Formularios', 'active' => false],
                    ['title' => 'Formularios', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],

                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerEventsTrailsProject':
                $titlesRight = [
                    ['title' => 'Eventos-Deportes', 'url' => route('managerBusiness', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
        }
        $result = '<div class="row">';
        $result .= '    <div class="col-12">';
        $result .= '      <div class="page-title-box">';
        $result .= '        <div class="page-title-right">';
        $result .= '             <ol class="breadcrumb m-0">';
        foreach ($paramsCurrent['titles-right'] as $kye => $row) {
            $activeClass = $row['active'] == true ? ' active' : '';
            $href = isset($row['url']) ? ' href="' . $row['url'] . '"' : 'href="javascript: void(0);"';

            $result .= '<li class="breadcrumb-item ' . $activeClass . '"><a ' . $href . '>' . $row['title'] . '</a></li>';
        }


        $result .= '             </ol>';
        $result .= '        </div>';
        $titleBusiness = '<span class="page-title__first">' . $paramsCurrent['title-left'] . '</span> - <span class="page-title__second">  ' . (isset($business->title) ? $business->title : "") . '</span>';
        $result .= '        <h4 class="page-title"><a href="' . route('managerBusiness', ['id' => $params['id'], 'typeManager' => 'managerDashboard']) . '" >' . $titleBusiness . '</a></h4>';
        $result .= '     </div>';
        $result .= '    </div>';
        $result .= '</div>';


        return $result;
    }
}
