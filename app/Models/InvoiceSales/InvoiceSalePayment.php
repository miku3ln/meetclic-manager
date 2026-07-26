<?php

namespace App\Models\InvoiceSales;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class InvoiceSalePayment extends ModelManager
{
    protected $table = 'invoice_sale_payment';

    protected $fillable = [
        'invoice_sale_id',
        'type_payment_id',
        'amount',
        'provider',
        'reference',
        'extra_data',
        'created_at',
        'updated_at'
    ];

    protected $attributesData = [
        ['column' => 'invoice_sale_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_payment_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'amount', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'provider', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'reference', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'extra_data', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
    ];

    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        return [
            "invoice_sale_id" => "required|numeric",
            "type_payment_id" => "required|numeric",
            "amount" => "required|numeric",
            "provider" => "max:100",
            "reference" => "max:100"
        ];
    }

    // 🔗 RELACIONES
    public function invoiceSale()
    {
        return $this->belongsTo(InvoiceSale::class, 'invoice_sale_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PosPaymentMethod::class, 'type_payment_id');
    }
}
