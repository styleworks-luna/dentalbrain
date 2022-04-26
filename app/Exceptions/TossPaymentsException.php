<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class TossPaymentsException extends Exception
{
    private $body;

    public function __construct(ResponseInterface $response, Throwable $previous = null)
    {
        $this->body = json_decode($response->getBody(), true);
        parent::__construct($this->body['message'], $response->getStatusCode(), $previous);
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error('Toss Success Call failed', [$this->getCode(), $this->body,]);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $this->getMessage()
            ]);
        } else {
            return redirect()->back()->with('alert', $this->getMessage());
        }
    }
}
