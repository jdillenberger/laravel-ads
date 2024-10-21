<?php

namespace Jdillenberger\LaravelBaseline\Controllers\Traits;

trait HasDefaultApiResponse
{
    public function success(?string $message = null, $code = 200, $data = [])
    {
        return response(array_merge([
            '__successful' => true,
            '__message' => $message,
            '__code' => $code,

        ], $this->addData($data)), $code);
    }

    public function error(?string $message = null, int $code = 500, array $data = [])
    {
        return response(array_merge([
            '__successful' => false,
            '__message' => $message,
            '__code' => $code,
        ], $this->addData($data)), $code);
    }

    private function addData(array $data)
    {
        $datakeys = array_keys($data);
        $disallowed_keys = array_intersect($datakeys, ['__successful', '__message', '__code', '__active']);

        if (count($disallowed_keys)) {
            abort(500, __('response_parameters_invalid', ['parameters' => '['.implode(', ', $disallowed_keys).']']));
        }

        if (count($data) > 0) {
            return array_merge(['__datakeys' => $datakeys], $data);
        }

        return [];
    }

    public function successResourceFetched($data = [])
    {
        return $this->success(__('success:resource_fetched'), 200, $data);
    }

    public function successResourceCreated($data = [])
    {
        return $this->success(__('success:resource_created'), 201, $data);
    }

    public function successResourceUpdated($data = [])
    {
        return $this->success(__('success:resource_updated'), 200, $data);
    }

    public function successResourceDeleted($data = [])
    {
        return $this->success(__('success:resource_deleted'), 201, $data);
    }
}
