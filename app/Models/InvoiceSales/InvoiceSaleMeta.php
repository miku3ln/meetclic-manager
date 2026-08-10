<?php


namespace App\Models\InvoiceSales;
use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class InvoiceSaleMeta extends ModelManager
{
    protected $table = 'invoice_sale_meta';

    protected $fillable = [
        'invoice_sale_id',
        'ticket_code',
        'service_type',
        'created_at',
        'updated_at'
    ];

    protected $attributesData = [
        ['column' => 'invoice_sale_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'ticket_code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'service_type', 'type' => 'string', 'defaultValue' => 'DINE_IN', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
    ];

    public $timestamps = false;

    protected $field_main = 'ticket_code';

    public static function getRulesModel()
    {
        return [
            "invoice_sale_id" => "required|numeric",
            "ticket_code" => "required|max:50",
            "service_type" => "required|in:DINE_IN,TAKEAWAY,DELIVERY"
        ];
    }

    // 🔗 RELACIÓN
    public function invoiceSale()
    {
        return $this->belongsTo(InvoiceSale::class, 'invoice_sale_id');
    }
}
