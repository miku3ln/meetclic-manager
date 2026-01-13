<?php

namespace App\Infrastructure\Cms\Infrastructure\Adapters\Persistence\Repositories;

use Illuminate\Support\Facades\DB;
use App\Infrastructure\Cms\Domain\Gamification\Routing\Ports\BusinessReadPort;

class DbBusinessReadRepository implements BusinessReadPort
{
    public function findById(string|int $value,string $fieldComparate): ?array
    {
        // ✅ whitelist de campos permitidos para buscar un business
        $allowed = ['id', 'title', 'document', 'email'];
        if (!in_array($fieldComparate, $allowed, true)) {
            return null;
        }

        $row = DB::table('business as b')
            ->join('business_subcategories as sc', 'sc.id', '=', 'b.business_subcategories_id')
            ->join('business_categories as c', 'c.id', '=', 'sc.business_categories_id')
            ->where("b.$fieldComparate", $value)
            ->select([
                'b.id as business_id',
                'b.title as business_title',
                'b.status as business_status',
                'b.email as business_email',
                'b.user_id as business_user_owner',
                'b.description as business_description',

                'sc.id as subcategory_id',
                'sc.name as subcategory_name',
                'sc.status as subcategory_status',

                'c.id as category_id',
                'c.name as category_name',
                'c.status as category_status',
            ])
            ->first();

        if (!$row) return null;
        return (array) $row;
    }
}
