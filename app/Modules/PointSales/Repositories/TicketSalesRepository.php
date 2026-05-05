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

            ->where('ehis.entidad_data_id', $business_id)

            ->select([
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
                'pos_payment_method as ppm',
                'ppm.id',
                '=',
                'isp.payment_method_id'
            )

            ->whereIn('isp.invoice_sale_id', $invoiceIds)

            ->select([
                'isp.*',
                'ppm.name as payment_method'
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
                "meta" => $metas[$invoice->id] ?? null,
                "payments" => $payments[$invoice->id] ?? [],
                "details" => $details[$invoice->id] ?? [],
                "movements" => $movements[$invoice->id] ?? [],
            ];
        });

        return $pagination;
    }
}
