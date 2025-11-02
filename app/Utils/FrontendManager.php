<?php

namespace App\Utils;

use App\Utils\Util;
use Auth;

class FrontendManager
{


    public static function getDataManager($params)
    {
        $result = [];
        $header = self::getHeaderHtml($params);
        $result['content']['headerHtml'] = $header;

        return $result;
    }

    public static function getHeaderHtml($params)
    {
        $template = $params['modelDataManager'];


        $paramsCurrent = [
            'title-left' => 'Administracion',
            'titles-right' => [
                ['title' => 'Dashboard', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => 'managerDashboard']), 'active' => true],

            ]
        ];

        $typeManager = $params['typeManager'];
        switch ($typeManager) {

            case 'managerTemplateSlider':
                $titlesRight = [
                    ['title' => 'Sliders', 'active' => false],
                    ['title' => 'Principal', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerActivitiesGamification':
                $titlesRight = [
                    ['title' => 'Sliders', 'active' => false],
                    ['title' => 'Actividades Gamificacion', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerRewardsGamification':
                $titlesRight = [
                    ['title' => 'Sliders', 'active' => false],
                    ['title' => 'Premios Gamificacion', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerTemplateAboutUs':
                $titlesRight = [
                    ['title' => 'Secciones Pagina', 'active' => false],
                    ['title' => 'Quienes Somos', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;

            case 'managerTemplatePolicies':
                $titlesRight = [
                    ['title' => 'Secciones Pagina', 'active' => false],
                    ['title' => 'Politicas/Terminos', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerTemplateServices':
                $titlesRight = [
                    ['title' => 'Secciones Pagina', 'active' => false],
                    ['title' => 'Servicios', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerTemplateNews':
                $titlesRight = [
                    ['title' => 'Secciones Pagina', 'active' => false],
                    ['title' => 'Noticias', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerTemplateContactUs':
                $titlesRight = [
                    ['title' => 'Secciones Pagina', 'active' => false],
                    ['title' => 'Contáctanos', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;


            case 'managerTemplateBySource':
                $titlesRight = [
                    ['title' => 'Configuraciones', 'active' => false],
                    ['title' => 'Imagenes', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerTemplatePayments':
                $titlesRight = [
                    ['title' => 'Configuraciones', 'active' => false],
                    ['title' => 'Formas de Pago', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


                ];
                $paramsCurrent['titles-right'] = $titlesRight;
                break;
            case 'managerTemplateConfigMailing':
                $titlesRight = [
                    ['title' => 'Configuraciones', 'active' => false],
                    ['title' => 'Mail', 'url' => route('frontendManagerBackend', ['id' => $params['id'], 'typeManager' => $typeManager]), 'active' => true],


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
        $titleBusiness = '<span class="page-title__first">' . $paramsCurrent['title-left'] . '</span> - <span class="page-title__second">  ' . ($template->value) . '</span>';
        $result .= '        <h4 class="page-title"><a href="' . route('managerBusiness', ['id' => $params['id'], 'typeManager' => 'managerDashboard']) . '" >' . $titleBusiness . '</a></h4>';
        $result .= '     </div>';
        $result .= '    </div>';
        $result .= '</div>';


        return $result;
    }
}
