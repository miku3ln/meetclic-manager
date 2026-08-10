<?php

namespace App\Modules\PointSales\Repositories ;



use App\Core\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class TicketSalesRepository extends BaseRepository
{
    public function getTicketSales($params)
    {
        $business_id = $params["business_id"];

        /*
        |--------------------------------------------------------------------------
        | QUERY PRINCIPAL
        |--------------------------------------------------------------------------
        */

        $query = DB::table('invoice_sale as i')

            ->join(
                'entity_has_invoice_sale as ehis',
                'ehis.factura_venta_id',
                '=',
                'i.id'
            )

            /*
            |--------------------------------------------------------------------------
            | ==============================================================
            | CUSTOMER DE LA FACTURA
            | ==============================================================
            |--------------------------------------------------------------------------
            */

            ->leftJoin(
                'customer as c',
                'c.id',
                '=',
                'i.customer_id'
            )

            ->leftJoin(
                'people as pe',
                'pe.id',
                '=',
                'c.people_id'
            )

            ->leftJoin(
                'people_type_identification as pti',
                'pti.id',
                '=',
                'c.people_type_identification_id'
            )

            ->leftJoin(
                'ruc_type as rt',
                'rt.id',
                '=',
                'c.ruc_type_id'
            )

            /*
            |--------------------------------------------------------------------------
            | ==============================================================
            | EMPLOYEE
            | ==============================================================
            |--------------------------------------------------------------------------
            |
            | invoice_sale.user_id -> users.id
            |
            */

            ->leftJoin(
                'users as u',
                'u.id',
                '=',
                'i.user_id'
            )

            /*
            |--------------------------------------------------------------------------
            | RELACIÓN EMPLOYEE -> CUSTOMER
            |--------------------------------------------------------------------------
            |
            | users.id -> customer_by_profile.user_id
            |
            */

            ->leftJoin(
                'customer_by_profile as cbp',
                'cbp.user_id',
                '=',
                'u.id'
            )

            /*
            |--------------------------------------------------------------------------
            | CUSTOMER DEL EMPLOYEE
            |--------------------------------------------------------------------------
            |
            | customer_by_profile.customer_id -> customer.id
            |
            | Usamos una segunda instancia de customer.
            |
            */

            ->leftJoin(
                'customer as ec',
                'ec.id',
                '=',
                'cbp.customer_id'
            )

            /*
            |--------------------------------------------------------------------------
            | PEOPLE DEL EMPLOYEE
            |--------------------------------------------------------------------------
            */

            ->leftJoin(
                'people as epe',
                'epe.id',
                '=',
                'ec.people_id'
            )

            /*
            |--------------------------------------------------------------------------
            | TIPO DE IDENTIFICACIÓN DEL EMPLOYEE
            |--------------------------------------------------------------------------
            */

            ->leftJoin(
                'people_type_identification as epti',
                'epti.id',
                '=',
                'ec.people_type_identification_id'
            )

            /*
            |--------------------------------------------------------------------------
            | RUC TYPE DEL EMPLOYEE
            |--------------------------------------------------------------------------
            */

            ->leftJoin(
                'ruc_type as ert',
                'ert.id',
                '=',
                'ec.ruc_type_id'
            )

            /*
            |--------------------------------------------------------------------------
            | BUSINESS
            |--------------------------------------------------------------------------
            */

            ->where(
                'ehis.entidad_data_id',
                $business_id
            )

            /*
            |--------------------------------------------------------------------------
            | SELECT
            |--------------------------------------------------------------------------
            */

            ->select([

                /*
                |--------------------------------------------------------------------------
                | INVOICE
                |--------------------------------------------------------------------------
                */

                'i.id',
                'i.customer_id',
                'i.invoice_code',
                'i.invoice_value',
                'i.discount_value',
                'i.status',
                'i.user_id',
                'i.observations',
                'i.value_taxes',
                'i.subtotal',
                'i.invoice_date',
                'i.created_at',
                'i.voucher_type_id',
                'i.debt',

                /*
                |--------------------------------------------------------------------------
                | ==============================================================
                | EMPLOYEE - USERS
                | ==============================================================
                */

                'u.id as employee_user_id',
                'u.name as employee_user_name',
                'u.email as employee_user_email',
                'u.username as employee_user_username',

                /*
                |--------------------------------------------------------------------------
                | EMPLOYEE - CUSTOMER
                |--------------------------------------------------------------------------
                */

                'ec.id as employee_customer_id',
                'ec.identification_document as employee_identification_document',
                'ec.people_type_identification_id as employee_people_type_identification_id',
                'ec.people_id as employee_people_id',
                'ec.ruc_type_id as employee_ruc_type_id',
                'ec.has_representative as employee_has_representative',

                /*
                |--------------------------------------------------------------------------
                | EMPLOYEE - PEOPLE
                |--------------------------------------------------------------------------
                */

                'epe.id as employee_people_id',
                'epe.last_name as employee_last_name',
                'epe.name as employee_name',
                'epe.birthdate as employee_birthdate',
                'epe.gender as employee_gender',

                /*
                |--------------------------------------------------------------------------
                | EMPLOYEE - IDENTIFICATION TYPE
                |--------------------------------------------------------------------------
                */

                'epti.id as employee_identification_type_id',
                'epti.name as employee_identification_type_name',
                'epti.description as employee_identification_type_description',
                'epti.code as employee_identification_type_code',

                /*
                |--------------------------------------------------------------------------
                | EMPLOYEE - RUC TYPE
                |--------------------------------------------------------------------------
                */

                'ert.id as employee_ruc_type_id',
                'ert.name as employee_ruc_type_name',

                /*
                |--------------------------------------------------------------------------
                | CUSTOMER DE LA FACTURA
                |--------------------------------------------------------------------------
                */

                'c.id as customer_id',
                'c.identification_document as customer_identification_document',
                'c.people_type_identification_id as customer_people_type_identification_id',
                'c.people_id as customer_people_id',
                'c.ruc_type_id as customer_ruc_type_id',
                'c.has_representative as customer_has_representative',

                /*
                |--------------------------------------------------------------------------
                | CUSTOMER - PEOPLE
                |--------------------------------------------------------------------------
                */

                'pe.id as customer_people_id',
                'pe.last_name as customer_last_name',
                'pe.name as customer_name',
                'pe.birthdate as customer_birthdate',
                'pe.gender as customer_gender',

                /*
                |--------------------------------------------------------------------------
                | CUSTOMER - IDENTIFICATION TYPE
                |--------------------------------------------------------------------------
                */

                'pti.id as customer_identification_type_id',
                'pti.name as customer_identification_type_name',
                'pti.description as customer_identification_type_description',
                'pti.code as customer_identification_type_code',

                /*
                |--------------------------------------------------------------------------
                | CUSTOMER - RUC TYPE
                |--------------------------------------------------------------------------
                */

                'rt.id as customer_ruc_type_id',
                'rt.name as customer_ruc_type_name',

                /*
                |--------------------------------------------------------------------------
                | CUSTOMER BY PROFILE
                |--------------------------------------------------------------------------
                */

                'cbp.id as customer_profile_id',
            ]);


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $this->applySearch($query, $params['searchPhrase'] ?? null, [
            'i.invoice_code',
            'i.status',
            'i.invoice_date',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PAGINATE
        |--------------------------------------------------------------------------
        */

        $pagination = $this->paginate($query, $params, 'i.id');

        $rows = collect($pagination['rows']);

        if ($rows->isEmpty()) {
            return $pagination;
        }

        /*
        |--------------------------------------------------------------------------
        | IDS
        |--------------------------------------------------------------------------
        */

        $invoiceIds = $rows->pluck('id')->toArray();

        /*
        |--------------------------------------------------------------------------
        | META
        |--------------------------------------------------------------------------
        */

        $metas = DB::table('invoice_sale_meta')
            ->whereIn('invoice_sale_id', $invoiceIds)
            ->get()
            ->keyBy('invoice_sale_id');

        /*
        |--------------------------------------------------------------------------
        | PAYMENTS
        |--------------------------------------------------------------------------
        */

        $payments = DB::table('invoice_sale_payment as isp')

            ->leftJoin(
                'types_payments as ppm',
                'ppm.id',
                '=',
                'isp.type_payment_id'
            )

            ->whereIn('isp.invoice_sale_id', $invoiceIds)

            ->select([
                'isp.*',
                'ppm.value as payment_method'
            ])

            ->get()

            ->groupBy('invoice_sale_id');

        /*
        |--------------------------------------------------------------------------
        | DETAILS
        |--------------------------------------------------------------------------
        */

        $details = DB::table('invoice_sale_by_details as d')

            ->join('product as p', 'p.id', '=', 'd.product_id')

            ->whereIn('d.invoice_sale_id', $invoiceIds)

            ->select([
                'd.id',
                'd.invoice_sale_id',
                'd.product_id',
                'd.quantity',
                'd.unit_price',
                'd.discount_percentage',
                'd.tax_percentage',
                'd.subtotal',
                'd.total',

                'p.code',
                'p.name',
                'p.product_type',
            ])

            ->get()

            ->groupBy('invoice_sale_id');

        /*
        |--------------------------------------------------------------------------
        | MOVEMENTS
        |--------------------------------------------------------------------------
        */

        $movements = DB::table('inventory_movement')

            ->whereIn('reference_id', $invoiceIds)

            ->select([
                'id',
                'reference_id',
                'product_id',
                'movement_type',
                'quantity',
                'created_at'
            ])

            ->get()

            ->groupBy('reference_id');

        /*
        |--------------------------------------------------------------------------
        | MAP FINAL
        |--------------------------------------------------------------------------
        */

        $pagination['rows'] = $rows->map(function ($invoice) use (
            $metas,
            $payments,
            $details,
            $movements
        ) {

            return [
                "header" => $invoice,

                "employee" => [

                    /*
                    |--------------------------------------------------------------
                    | USERS
                    |--------------------------------------------------------------
                    */

                    "user" => [
                        "id" =>
                            $invoice->employee_user_id,

                        "name" =>
                            $invoice->employee_user_name,

                        "email" =>
                            $invoice->employee_user_email,

                        "username" =>
                            $invoice->employee_user_username,
                    ],

                    /*
                    |--------------------------------------------------------------
                    | CUSTOMER DEL EMPLOYEE
                    |--------------------------------------------------------------
                    */

                    "customer" => [

                        "id" =>
                            $invoice->employee_customer_id,

                        "identification_document" =>
                            $invoice->employee_identification_document,

                        "people_type_identification_id" =>
                            $invoice->employee_people_type_identification_id,

                        "people_id" =>
                            $invoice->employee_people_id,

                        "ruc_type_id" =>
                            $invoice->employee_ruc_type_id,

                        "has_representative" =>
                            $invoice->employee_has_representative,

                        /*
                        |----------------------------------------------------------
                        | PEOPLE
                        |----------------------------------------------------------
                        */

                        "people" => [

                            "id" =>
                                $invoice->employee_people_id,

                            "last_name" =>
                                $invoice->employee_last_name,

                            "name" =>
                                $invoice->employee_name,

                            "birthdate" =>
                                $invoice->employee_birthdate,

                            "gender" =>
                                $invoice->employee_gender,
                        ],

                        /*
                        |----------------------------------------------------------
                        | IDENTIFICATION TYPE
                        |----------------------------------------------------------
                        */

                        "identification_type" => [

                            "id" =>
                                $invoice->employee_identification_type_id,

                            "name" =>
                                $invoice->employee_identification_type_name,

                            "description" =>
                                $invoice->employee_identification_type_description,

                            "code" =>
                                $invoice->employee_identification_type_code,
                        ],

                        /*
                        |----------------------------------------------------------
                        | RUC TYPE
                        |----------------------------------------------------------
                        */

                        "ruc_type" => [

                            "id" =>
                                $invoice->employee_ruc_type_id,

                            "name" =>
                                $invoice->employee_ruc_type_name,
                        ],
                    ],
                ],

                /*
                |--------------------------------------------------------------------------
                | ==============================================================
                | CUSTOMER DE LA FACTURA
                | ==============================================================
                */

                "customer" => [

                    "id" =>
                        $invoice->customer_id,

                    "identification_document" =>
                        $invoice->customer_identification_document,

                    "people_type_identification_id" =>
                        $invoice->customer_people_type_identification_id,

                    "people_id" =>
                        $invoice->customer_people_id,

                    "ruc_type_id" =>
                        $invoice->customer_ruc_type_id,

                    "has_representative" =>
                        $invoice->customer_has_representative,

                    /*
                    |--------------------------------------------------------------
                    | PEOPLE
                    |--------------------------------------------------------------
                    */

                    "people" => [

                        "id" =>
                            $invoice->customer_people_id,

                        "last_name" =>
                            $invoice->customer_last_name,

                        "name" =>
                            $invoice->customer_name,

                        "birthdate" =>
                            $invoice->customer_birthdate,

                        "gender" =>
                            $invoice->customer_gender,
                    ],

                    /*
                    |--------------------------------------------------------------
                    | IDENTIFICATION TYPE
                    |--------------------------------------------------------------
                    */

                    "identification_type" => [

                        "id" =>
                            $invoice->customer_identification_type_id,

                        "name" =>
                            $invoice->customer_identification_type_name,

                        "description" =>
                            $invoice->customer_identification_type_description,

                        "code" =>
                            $invoice->customer_identification_type_code,
                    ],

                    /*
                    |--------------------------------------------------------------
                    | RUC TYPE
                    |--------------------------------------------------------------
                    */

                    "ruc_type" => [

                        "id" =>
                            $invoice->customer_ruc_type_id,

                        "name" =>
                            $invoice->customer_ruc_type_name,
                    ],
                ],

                /*
                |--------------------------------------------------------------------------
                | CUSTOMER PROFILE
                |--------------------------------------------------------------------------
                */

                "customer_profile" => [

                    "id" =>
                        $invoice->customer_profile_id,
                ],
                "meta" => $metas[$invoice->id] ?? null,
                "payments" => $payments[$invoice->id] ?? [],
                "details" => $details[$invoice->id] ?? [],
                "movements" => $movements[$invoice->id] ?? [],
            ];
        });

        return $pagination;
    }
}
