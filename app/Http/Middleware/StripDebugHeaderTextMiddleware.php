<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StripDebugHeaderTextMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->is('catalog*')) {
            return $response;
        }

        $contentType = (string) $response->headers->get('Content-Type', '');

        if (! str_contains(strtolower($contentType), 'text/html')) {
            return $response;
        }

        $content = $response->getContent();

        if (! is_string($content) || $content === '') {
            return $response;
        }

        $sanitized = preg_replace(
            '/^\s*HTTP\/1\.[01]\s+\d{3}[^\r\n]*\R(?:[A-Za-z\-]+:\s*[^\r\n]*\R)+\R*/',
            '',
            $content,
            1
        );

        if (is_string($sanitized) && $sanitized !== $content) {
            $response->setContent($sanitized);
        }

        return $response;
    }
}

