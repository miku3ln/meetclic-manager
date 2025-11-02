<?php

namespace App\Services;

use App\Repositories\BusinessRepository;
use App\Repositories\MaritimeDepartureRepository;

class BusinessAppService
{
    protected $repository;
    protected $maritimeDepartureRepository;

    public function __construct(BusinessRepository $repository,MaritimeDepartureRepository $maritimeDepartureRepository)
    {
        $this->repository = $repository;
        $this->maritimeDepartureRepository = $maritimeDepartureRepository;

    }

    public function searchNearbyBusinesses($latitude, $longitude, $radiusKm = 10, $subcategoryIds = [])
    {

        return $this->repository->searchNearbyBusinesses($latitude, $longitude, $radiusKm , $subcategoryIds );
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
