<?php

namespace Jdillenberger\LaravelBaseline\Controllers\Traits;

use Illuminate\Support\Str;

trait HasDefaultCrud
{
    use HasDefaultApiResponse;

    public function defaultList($class, $where = null)
    {
        \Illuminate\Support\Facades\Gate::authorize('list', $class);

        $class_slug = Str::snake(Str::pluralStudly(class_basename($class)));
        $pager = is_null($where) ? $class::filter()->paginate() : $class::where($where)->filter()->paginate();

        return $this->successResourceFetched([
            'pagination' => $this->pagerMeta($pager),
            $class_slug => $pager->items(),
        ]);
    }

    public function defaultCreate($class, $data)
    {
        \Illuminate\Support\Facades\Gate::authorize('create', $class);

        $organization = $class::create($data);

        $class_slug = Str::snake(class_basename($class));

        return $this->successResourceCreated([
            $class_slug => $organization,
        ]);
    }

    public function defaultSingle(\Illuminate\Database\Eloquent\Model $model)
    {
        \Illuminate\Support\Facades\Gate::authorize('single', $model);

        if (! $model->exists()) {
            abort(404);
        }

        $class_slug = Str::snake(class_basename($model::class));

        return $this->successResourceFetched([
            $class_slug => $model,
        ]);
    }

    public function defaultUpdate(\Illuminate\Database\Eloquent\Model $model, $data)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $model);

        if (! $model->exists()) {
            abort(404);
        }

        if (! $model->update($data)) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\ResourceUpdateFailedException;
        }

        $class_slug = Str::snake(class_basename($model::class));

        return $this->successResourceUpdated([
            $class_slug => $model,
        ]);
    }

    public function defaultDelete(\Illuminate\Database\Eloquent\Model $model)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $model);

        if (! $model->exists()) {
            abort(404);
        }

        if (! $model->delete()) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\ResourceDeletionFailedException;
        }

        return $this->successResourceDeleted();
    }
}
