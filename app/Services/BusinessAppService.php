<?php

namespace App\Services;

use App\Repositories\BusinessRepository;
use App\Repositories\MaritimeDepartureRepository;
use Illuminate\Support\Facades\Cache;


class BusinessAppService
{
    protected $repository;
    protected $maritimeDepartureRepository;

    public function __construct(BusinessRepository $repository,MaritimeDepartureRepository $maritimeDepartureRepository)
    {
        $this->repository = $repository;
        $this->maritimeDepartureRepository = $maritimeDepartureRepository;

    }

    public function searchNearbyBusinesses2($latitude, $longitude, $radiusKm = 10, $subcategoryIds=null,   $onlyWithRedeemableRewards = null,
                                                                                                          $onlyWithGamesActive = null,
                                                                                                          $onlyAlliedCompanies = null ,$searchQuery='',$type=null)
    {

        return $this->repository->searchNearbyBusinesses($latitude, $longitude, $radiusKm , $subcategoryIds,   $onlyWithRedeemableRewards ,
            $onlyWithGamesActive,
            $onlyAlliedCompanies ,$searchQuery ,$type);
    }


    public function searchNearbyBusinesses(
        $latitude,
        $longitude,
        $radiusKm = 10,
        $subcategoryIds = null,
        $onlyWithRedeemableRewards = null,
        $onlyWithGamesActive = null,
        $onlyAlliedCompanies = null,
        $searchQuery = '',
        $type = null
    ) {

        // ==========================================
        // 1. CONFIGURACIÓN GENERAL
        // ==========================================

        $cache = Cache::store('file');

        $type = filter_var(
            $type,
            FILTER_VALIDATE_INT,
            FILTER_NULL_ON_FAILURE
        );

        $validTypes = [1, 2, 3, 4];

        $useCache = in_array(
            $type,
            $validTypes,
            true
        );

        // Caché independiente para cada ruta.
        // Duración: 24 horas desde su creación.

        $cacheKey = $useCache
            ? "maskana:businesses:v5:type:{$type}"
            : null;

        $cacheTtl = 86400;

        // ==========================================
        // 2. CONSULTAR EMPRESAS Y PROMOCIONES
        // ==========================================

        $loadBusinesses = function () use (
            $latitude,
            $longitude,
            $radiusKm,
            $onlyWithRedeemableRewards,
            $onlyWithGamesActive,
            $onlyAlliedCompanies,
            $type
        ) {

            // ==========================================
            // 2.1 EMPRESAS DE LA RUTA
            // ==========================================

            $businesses = $this->repository->searchNearbyBusinesses(
                $latitude,
                $longitude,
                $radiusKm,
                null,
                $onlyWithRedeemableRewards,
                $onlyWithGamesActive,
                $onlyAlliedCompanies,
                '',
                $type
            );

            // ==========================================
            // 2.2 EMPRESAS EXCLUIDAS
            // ==========================================

            $excludeBusinessIds = collect($businesses)
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values()
                ->all();

            // Mantener exclusiones originales.

            $additionalExclusions = [
                42,
                126,
                124,
                122,
                123,
                5
            ];

            $excludeBusinessIds = array_values(
                array_unique(
                    array_merge(
                        $excludeBusinessIds,
                        $additionalExclusions
                    )
                )
            );

            // ==========================================
            // 2.3 EMPRESAS CON PROMOCIONES
            // ==========================================

            $businessesPromotions =
                $this->repository->searchNearbyBusinessPromotion(
                    $latitude,
                    $longitude,
                    $radiusKm,
                    null,
                    $excludeBusinessIds,
                    ''
                );

            // ==========================================
            // 2.4 COMBINAR EMPRESAS
            // ==========================================

            $businessesMap = collect($businesses)
                ->keyBy('id');

            foreach ($businessesPromotions as $promotionBusiness) {

                $businessId = $promotionBusiness->id;

                if ($businessesMap->has($businessId)) {

                    $business = $businessesMap->get($businessId);

                    $business->promotions =
                        $promotionBusiness->promotions ?? [];

                    $businessesMap->put(
                        $businessId,
                        $business
                    );

                } else {

                    $promotionBusiness->promotions =
                        $promotionBusiness->promotions ?? [];

                    $businessesMap->put(
                        $businessId,
                        $promotionBusiness
                    );
                }
            }

            // ==========================================
            // 2.5 NORMALIZAR PROMOCIONES
            // ==========================================

            return $businessesMap
                ->map(function ($business) {

                    $business->promotions =
                        $business->promotions ?? [];

                    return $business;
                })
                ->values()
                ->all();
        };

        // ==========================================
        // 3. OBTENER RESULTADOS CON CACHÉ
        // ==========================================

        if ($useCache) {

            // ==========================================
            // 3.1 BUSCAR EN CACHÉ
            // ==========================================

            $businesses = $cache->get($cacheKey);

            if ($businesses === null) {

                // ==========================================
                // 3.2 EVITAR CONSULTAS SIMULTÁNEAS
                // ==========================================

                $businesses = $cache
                    ->lock("{$cacheKey}:lock", 30)
                    ->block(10, function () use (
                        $cache,
                        $cacheKey,
                        $cacheTtl,
                        $loadBusinesses
                    ) {

                        // Verificar nuevamente la caché
                        // después de obtener el bloqueo.

                        $cachedBusinesses = $cache->get(
                            $cacheKey
                        );

                        if ($cachedBusinesses !== null) {
                            return $cachedBusinesses;
                        }

                        // ==========================================
                        // 3.3 CONSULTAR BASE DE DATOS
                        // ==========================================

                        $data = $loadBusinesses();

                        // ==========================================
                        // 3.4 GUARDAR DURANTE 24 HORAS
                        // ==========================================

                        $cache->put(
                            $cacheKey,
                            $data,
                            $cacheTtl
                        );

                        return $data;
                    });
            }

        } else {

            // Para type diferente de 1, 2, 3 y 4,
            // consultar directamente la base de datos.

            $businesses = $loadBusinesses();
        }

        // ==========================================
        // 4. CONVERTIR RESULTADOS A COLLECTION
        // ==========================================

        $results = collect($businesses);

        // ==========================================
        // 5. FILTRAR POR SUBCATEGORÍAS
        // ==========================================

        if (!empty($subcategoryIds)) {

            $ids = is_array($subcategoryIds)
                ? $subcategoryIds
                : explode(',', (string) $subcategoryIds);

            $ids = collect($ids)
                ->map(fn ($id) => trim((string) $id))
                ->filter(fn ($id) => $id !== '')
                ->values()
                ->all();

            if (!empty($ids)) {

                $results = $results->filter(
                    function ($business) use ($ids) {

                        $business = (array) $business;

                        $subcategoryId =
                            $business['business_subcategories_id']
                            ?? null;

                        return in_array(
                            (string) $subcategoryId,
                            $ids,
                            true
                        );
                    }
                );
            }
        }

        // ==========================================
        // 6. FILTRAR POR TEXTO
        // ==========================================

        $search = mb_strtolower(
            trim((string) $searchQuery)
        );

        if ($search !== '') {

            $results = $results->filter(
                function ($business) use ($search) {

                    $business = (array) $business;

                    $fields = [
                        'business_name',
                        'title',
                        'description',
                        'subcategory_name'
                    ];

                    foreach ($fields as $field) {

                        $value = mb_strtolower(
                            (string) ($business[$field] ?? '')
                        );

                        if (str_contains($value, $search)) {
                            return true;
                        }
                    }

                    return false;
                }
            );
        }

        // ==========================================
        // 7. DEVOLVER RESULTADOS
        // ==========================================

        return $results
            ->values()
            ->all();
    }

    public function getCategoriesBusiness($params)
    {

        return $this->repository->getCategoriesBusiness($params);
    }
    public function businessDetails($businessId)
    {

        return $this->repository->businessDetails($businessId );
    }
    public function getDeparturesWithCustomers($businessId,$from, $to)
    {

        return $this->maritimeDepartureRepository->getDeparturesWithCustomers($businessId ,$from, $to);
    }
}
