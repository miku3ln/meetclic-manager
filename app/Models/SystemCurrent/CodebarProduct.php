<?php

namespace App\Models;
namespace App\Models\SystemCurrent;

use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\ModelManager;

class CodebarProduct extends ModelManager
{
    protected $connection = 'firebird'; // Conexión alterna
    protected $table = 'VIEW_CODEBAR_PRODUCTS';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;


}
