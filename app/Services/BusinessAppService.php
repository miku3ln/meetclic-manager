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
        // 1. CONSTRUIR CLAVE POR TYPE
        // ==========================================

        // CAMBIO:
        // Utilizar caché local de archivos en lugar
        // de Redis remoto.
        //
        // ANTES:
        // $cache = Cache::store('redis');

        $cache = Cache::store('file');

        $cacheKey = "maskana:businesses:type:{$type}";

        // ==========================================
        // 2. PREGUNTAR PRIMERO A LA CACHÉ
        // ==========================================

        if ($cache->has($cacheKey)) {

            // SÍ EXISTE:
            // Recuperar empresas almacenadas.
            // No consultar MySQL.

            $businesses = $cache->get($cacheKey);

        } else {

            // NO EXISTE:
            // Consultar MySQL únicamente por type.
            // No aplicar subcategoryIds ni searchQuery.

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
            // 3. GUARDAR DATOS COMPLETOS EN CACHÉ
            // ==========================================

            // Mantener la caché sin vencimiento
            // automático, igual que antes con Redis.

            $cache->forever($cacheKey, $businesses);
        }

        // ==========================================
        // 4. FILTRAR LOS DATOS OBTENIDOS
        // ==========================================

        $results = collect($businesses);

        // FILTRAR POR SUBCATEGORÍAS
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
                            $business['business_subcategories_id'] ?? null;

                        return in_array(
                            (string) $subcategoryId,
                            $ids,
                            true
                        );
                    }
                );
            }
        }

        // FILTRAR POR TEXTO
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
                        'subcategory_name',
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
        // 5. DEVOLVER RESULTADOS FILTRADOS
        // ==========================================

        return $results->values()->all();
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
