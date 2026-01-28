<?php

namespace App\Infrastructure\Cms\Application\Gamification\Routing\UseCases;

use App\Infrastructure\Cms\Domain\Gamification\Routing\DTOs\RouteResolveInputDTO;
use App\Infrastructure\Cms\Domain\Gamification\Routing\DTOs\RouteResolveResultDTO;
use App\Infrastructure\Cms\Domain\Gamification\Routing\Ports\BusinessReadPort;

class ResolveRouteContextUseCase
{
    // === ROUTE NAMES (tus constantes) ===
    public const GAMIFICATION_BUSINESS_DETAILS = "businessDetails";
    public const GAMIFICATION_BUSINESS_CHASQUI = "chasqui-routes";
    public const GAMIFICATION_BUSINESS_SHOP = "shop-business";
    public const GAMIFICATION_BUSINESS_PRODUCT_SERVICE = "productDetailsByBusiness";
    public const GAMIFICATION_BUSINESS_PULLKAY = "businessPullkay";
    public const GAMIFICATION_BUSINESS_RIMAY = "rimay-business";
    public const GAMIFICATION_BUSINESS_RIMAY_REGISTERS = "rimay-registers-business";
    public const GAMIFICATION_BUSINESS_RATE_REGISTERS = "rates-registers-business";
    public const GAMIFICATION_BUSINESS_RATE_REGISTER = "rate-register-business";
    public const GAMIFICATION_BUSINESS_REWARDS_REGISTERS = "rewards-business";

    public const GAMIFICATION_CMS_DASHBOARD = "profileAccount";
    public const GAMIFICATION_CMS_ACCOUNT = "myProfile";
    public const GAMIFICATION_CMS_PASSWORD = "password";
    public const GAMIFICATION_CMS_BUSINESS = "business";
    public const GAMIFICATION_CMS_EMPLOYER = "businessEmployer";
    public const GAMIFICATION_CMS_ORDERS = "orders";
    public const GAMIFICATION_CMS_POINTS_SALES = "pointsSales";
    public const GAMIFICATION_CMS_ABOUT_US = "aboutUsBee";
    public const GAMIFICATION_CMS_HOW_IT_WORKS = "howItWorks";
    public const GAMIFICATION_CMS_TEAM = "homeBackLine";
    public const GAMIFICATION_CMS_PROJECT_KICHWA = "homeChaski";
    public const GAMIFICATION_CMS_PROJECT_KICHWA_YACHANA = "yachaSun";
    public const GAMIFICATION_CMS_PROJECT_KICHWA_DICCIONARIO = "diccionario";
    public const GAMIFICATION_CMS_PROJECT_KICHWA_TRADUCTOR = "traductor";
    public const GAMIFICATION_CMS_SEARCH = "search";

    /**
     * MAPA: route_name => ['required'=>[], 'optional'=>[], 'keyRelation'=>...]
     */
    private const ROUTE_PARAM_MAP = [
        self::GAMIFICATION_BUSINESS_DETAILS => [
            'required' => ['id'],
            'optional' => ['type'], // SOLO si tu ruta lo tiene
            'keyRelation' => ['business' => 'id'], // tabla => campo
        ],
        self::GAMIFICATION_BUSINESS_CHASQUI => [
            'required' => ['id'], 'optional' => []
        ],
        self::GAMIFICATION_BUSINESS_SHOP => [
            'required' => ['id'], 'optional' => [],
            'keyRelation' => ['business' => 'id'],
        ],
        self::GAMIFICATION_BUSINESS_PRODUCT_SERVICE => [
            'required' => ['id'], 'optional' => [],
        ],
        self::GAMIFICATION_BUSINESS_PULLKAY => [
            'required' => ['id'], 'optional' => [],
            'keyRelation' => ['business' => 'id'],
        ],
        self::GAMIFICATION_BUSINESS_RIMAY => [
            'required' => ['id'], 'optional' => [],
            'keyRelation' => ['business' => 'id'],
        ],
        self::GAMIFICATION_BUSINESS_RIMAY_REGISTERS => [
            'required' => ['id'], 'optional' => [],
            'keyRelation' => ['business' => 'id'],
        ],
        self::GAMIFICATION_BUSINESS_RATE_REGISTERS => [
            'required' => ['id'], 'optional' => [],
            'keyRelation' => ['business' => 'id'],
        ],
        self::GAMIFICATION_BUSINESS_RATE_REGISTER => [
            'required' => ['id'], 'optional' => [],
            'keyRelation' => ['business' => 'id'],
        ],
        self::GAMIFICATION_BUSINESS_REWARDS_REGISTERS => [
            'required' => ['id'], 'optional' => [],
            'keyRelation' => ['business' => 'id'],
        ],

        // CMS sin params
        self::GAMIFICATION_CMS_DASHBOARD => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_ACCOUNT => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_PASSWORD => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_BUSINESS => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_EMPLOYER => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_ORDERS => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_POINTS_SALES => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_ABOUT_US => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_HOW_IT_WORKS => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_TEAM => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_PROJECT_KICHWA => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_PROJECT_KICHWA_YACHANA => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_PROJECT_KICHWA_DICCIONARIO => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_PROJECT_KICHWA_TRADUCTOR => ['required' => [], 'optional' => []],
        self::GAMIFICATION_CMS_SEARCH => ['required' => [], 'optional' => []],
    ];

    public function __construct(
        private readonly BusinessReadPort $businessRead
    )
    {
    }

    public function execute(RouteResolveInputDTO $dto): RouteResolveResultDTO
    {
        $routeName = trim($dto->routeName);
        $nameProcess = "";
        $typeProcess = "";

        if ($routeName === '') {
            return RouteResolveResultDTO::fail("No se pudo obtener route_name.");
        }
        $dataActions = self::ROUTE_PARAM_MAP;

        if (!isset($dataActions[$routeName])) {
            return RouteResolveResultDTO::fail("No esta permitido para gestion de Gamificaciòn: '{$routeName}'.");
        }

        $map = self::ROUTE_PARAM_MAP[$routeName];
        $required = $map['required'] ?? [];
        $optional = $map['optional'] ?? [];

        // 1) Validar requeridos
        $missing = [];
        foreach ($required as $k) {
            $val = $dto->routeParams[$k] ?? null;
            if ($val === null || $val === '') $missing[] = $k;
        }
        if ($missing) {
            return RouteResolveResultDTO::fail(
                "Faltan parámetros requeridos en la ruta ({$routeName}): " . implode(', ', $missing)
            );
        }

        // 2) Filtrar params esperados
        $expected = array_values(array_unique(array_merge($required, $optional)));
        $filtered = [];
        foreach ($expected as $k) {
            if (array_key_exists($k, $dto->routeParams)) {
                $filtered[$k] = $dto->routeParams[$k];
            }
        }

        // 3) Si hay keyRelation => resolver tabla/campo (por ahora solo business)
        $relation = $map['keyRelation'] ?? null;
        $relationData = null;

        if (is_array($relation) && isset($relation['business'])) {
            $typeProcess = "business";

            $nameProcess = "Empresa";

            $businessField = (string)$relation['business']; // ej "title"
            $businessId = $filtered['id'] ?? null;

            if ($businessId === null || $businessId === '') {
                return RouteResolveResultDTO::fail("No se pudo resolver business: falta id.");
            }
            $fieldComparate = $relation["business"];
            $isStringWithLetters = is_string($businessId) && preg_match('/[a-zA-Z]/', $businessId);
            if (in_array($routeName, ["rimay-business", "suggestion-mail-business"])) {

            } else if ("chasqui-routes" == $routeName) {

            } else if ("rate-register-business" == $routeName) {

            } else if ("rimay-registers-business" == $routeName) {

            } else if ("rewards-business" == $routeName) {

            } else if ("shop-business" == $routeName) {

            }
            if (!$isStringWithLetters) {
                $fieldComparate = "id";
            }
            $business = $this->businessRead->findById($businessId, $fieldComparate);
            if (!$business) {
                return RouteResolveResultDTO::fail("Empresa no existe para id='{$businessId}'.");
            }

            $relationData = $business;
        }

        return RouteResolveResultDTO::ok("Se obtuvo la informacion de la " . $nameProcess, [
            "routing" => [
                'route_name' => $routeName,
                'expected_route_params' => $expected,
                'route_params_present' => $filtered,
                'query_params' => $dto->queryParams,
            ],
            "relationManager" => [
                'id_value' => $filtered['id'] ?? null,
                'relation' => $relationData, // null si no aplica
                "typeProcess" => $typeProcess

            ]

        ]);
    }
}
