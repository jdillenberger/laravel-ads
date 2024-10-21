<?php

namespace Jdillenberger\LaravelBaseline\Controllers\Traits;

trait HasPagination
{
    public function pagerMeta($pager)
    {
        return [
            'pagination' => [
                'total' => $pager->total(),
                'count' => $pager->count(),
                'per_page' => $pager->perPage(),
                'current_page' => $pager->currentPage(),
                'total_pages' => $pager->lastPage(),
                'links' => [
                    'next' => $pager->nextPageUrl(),
                    'previous' => $pager->previousPageUrl(),
                ],
            ],
        ];
    }
}
