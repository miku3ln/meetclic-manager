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
        if ($cache->has($cacheKey)) {
            $businesses = $cache->get($cacheKey);
        } else {
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
            $excludeBusinessIds = collect($businesses)
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values()
                ->all();
            $excludeBusinessIds[] = 42;
            $businessesPromotions = $this->repository->searchNearbyBusinessPromotion(
                $latitude,
                $longitude,
                $radiusKm,
                null,
                $excludeBusinessIds,
                '',

            );

            $businessesMap = collect($businesses)
                ->keyBy('id');
            foreach ($businessesPromotions as $promotionBusiness) {
                $businessId = $promotionBusiness->id;
                if ($businessesMap->has($businessId)) {
                    $business = $businessesMap->get($businessId);

                    $business->promotions = $promotionBusiness->promotions ?? [];
                    $businessesMap->put($businessId, $business);

                } else {
                    $promotionBusiness->promotions =
                        $promotionBusiness->promotions ?? [];

                    $businessesMap->put(
                        $businessId,
                        $promotionBusiness
                    );
                }
            }

            /*
             * CASO 3:
             * Las empresas que no tengan promociones
             * deben tener promotions: []
             */
            $businesses = $businessesMap
                ->map(function ($business) {

                    $business->promotions = $business->promotions ?? [];

                    return $business;
                })
                ->values()
                ->all();
        }
        $results = collect($businesses);
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
