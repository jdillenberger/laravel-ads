<?php

namespace Jdillenberger\LaravelBaseline\Controllers;

class ExceptionsController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    protected $externalExceptions = [
        \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class,
    ];

    protected function isBaselineException($e)
    {
        return \Illuminate\Support\Str::startsWith($e::class, '\App\Services\Baseline');
    }

    public function handle(\Illuminate\Http\Request $request, \Exception $e)
    {

        if (in_array($e::class, $this->externalExceptions)) {
            return $this->renderExternalException($request, $e);
        }

        if ($this->isBaselineException($e)) {
            return $this->renderBaselineException($request, $e);
        }

    }

    public function renderBaselineException(\Illuminate\Http\Request $request, \Exception $e)
    {
        return $this->render($request, $e);
    }

    public function renderExternalException(\Illuminate\Http\Request $request, \Exception $e)
    {
        return $this->render($request, $e);
    }

    public function render(\Illuminate\Http\Request $request, \Exception $e)
    {
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
            return $this->error(__($e->getMessage()), $e->getStatusCode(), [
                'request' => [
                    'host' => $request->getSchemeAndHttpHost(),
                    'method' => $request->getMethod(),
                    'port' => $request->getPort(),
                    'path' => $request->getPathInfo(),
                ],
            ]);
        }

        return $this->error(__($e->getMessage()));
    }
}
