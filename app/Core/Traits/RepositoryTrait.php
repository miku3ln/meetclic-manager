<?php

namespace App\Core\Traits;

trait RepositoryTrait
{
    public function paginateQuery($query, $params, $defaultSort = 'id')
    {
        $sort = 'asc';

        if (isset($params['sortType'])) {
            $sort = $params['sortType'];
        }

        $field = $defaultSort;

        if (isset($params['sort'])) {
            $column = array_keys($params['sort'])[0];

            $field = $column;
            $sort = $params['sort'][$column];
        }

        $page = isset($params['current'])
            ? (int) $params['current']
            : 1;

        $perpage = isset($params['rowCount'])
            ? (int) $params['rowCount']
            : 10;

        $total = $query->count();

        $query->orderBy($field, $sort);

        if ($perpage > 0) {
            $offset = ($page - 1) * $perpage;

            $query
                ->offset($offset)
                ->limit($perpage);
        }

        return [
            'total' => $total,
            'rows' => $query->get(),
            'current' => $page,
            'rowCount' => $perpage
        ];
    }

    public function applySearch($query, $search, $fields = [])
    {
        if (!$search) {
            return $query;
        }

        $like = "%{$search}%";

        $query->where(function ($q) use ($fields, $like) {
            foreach ($fields as $field) {
                $q->orWhere($field, 'like', $like);
            }
        });

        return $query;
    }
}
