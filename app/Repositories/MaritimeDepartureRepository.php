<?php

namespace App\Repositories;

use App\Models\MaritimeOperationsManagement\MaritimeDepartures;

class MaritimeDepartureRepository
{
    public function getDeparturesWithCustomers($businessId, $from = null, $to = null)
    {
        $query = MaritimeDepartures::with([
            'customers.customer.people'
        ])
            ->where('business_id', $businessId);

        // Filtro opcional: fecha desde
        if (!empty($from)) {
            $query->whereDate('arrival_time', '>=', $from);
        }

        // Filtro opcional: fecha hasta
        if (!empty($to)) {
            $query->whereDate('arrival_time', '<=', $to);
        }

        return $query->orderBy('arrival_time', 'asc') // Orden cronológico
        ->get()
            ->map(function ($departure) {
                return [
                    'business_id' => $departure->business_id,
                    'user_id' => $departure->user_id,
                    'user_management_id' => $departure->user_management_id,
                    'arrival_time' => $departure->arrival_time,
                    'responsible_name' => $departure->responsible_name,
                    'customers' => $departure->customers->map(function ($departureCustomer) {
                        $customer = $departureCustomer->customer;
                        $person = $customer->people;

                        return [
                            'documentNumber' => $customer->identification_document,
                            'fullName' => trim($person->first_name . ' ' . $person->last_name),
                            'type' => $departureCustomer->type,
                            'age' => $departureCustomer->age,
                        ];
                    })->toArray(),
                ];
            })->toArray();
    }

}

