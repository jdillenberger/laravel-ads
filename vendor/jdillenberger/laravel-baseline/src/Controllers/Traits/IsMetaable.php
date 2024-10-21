<?php

namespace Jdillenberger\LaravelBaseline\Controllers\Traits;

class IsMetaable
{
    use HasDefaultApiResponse;

    public function defaultListMeta(\Illuminate\Database\Eloquent\Model $morph)
    {
        $morph->meta()->get();

    }

    public function defaultSingleMeta(\Illuminate\Database\Eloquent\Model $morph, \Illuminate\Database\Eloquent\Model $meta) {}

    public function defaultCreateMeta(\Illuminate\Database\Eloquent\Model $morph) {}

    public function defaultUpdateMeta(\Illuminate\Database\Eloquent\Model $morph, \Illuminate\Database\Eloquent\Model $meta) {}

    public function defaultDeleteMeta(\Illuminate\Database\Eloquent\Model $morph, \Illuminate\Database\Eloquent\Model $meta) {}
}
