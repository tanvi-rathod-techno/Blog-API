<?php

use Illuminate\Http\Request;

if (!function_exists('getPaginationAttributes')) {
    function getPaginationAttributes(Request $request): array
    {
        return [
            'page' => $request->page ?? 1,
            'limit' => $request->limit ?? env('DEFAULT_PAGINATION_LIMIT', 10),
            'sort_by' => $request->sort_by ?? 'id',
            'order' => $request->order ?? 'desc',
        ];
    }
}
