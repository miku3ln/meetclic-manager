<?php

namespace App\Modules\PointSales\Services;
use App\Modules\PointSales\Repositories\TicketSalesRepository;

class TicketsSalesService
{
    protected $repo;

    public function __construct(TicketSalesRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getTicketSales($params)
    {

        return $this->repo->getTicketSales($params);
    }
}
