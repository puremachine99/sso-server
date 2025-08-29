<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImgProxyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // cek fleksibel content-type
        $contentType = $response->headers->get('Content-Type') ?? '';
        if (str_starts_with($contentType, 'text/html')) {
            $content = $response->getContent();

            $content = preg_replace_callback(
                '/<img\s+[^>]*src=["\']([^"\']+)["\']/i',
                function ($matches) {
                    $originalUrl = $matches[1];

                    if (str_contains($originalUrl, 'imgproxy.smartid.co.id')) {
                        return $matches[0];
                    }

                    $proxyUrl = "https://imgproxy.smartid.co.id/100x200,sc/plain/{$originalUrl}";

                    return str_replace($originalUrl, $proxyUrl, $matches[0]);
                },
                $content
            );

            $response->setContent($content);
        }

        return $response;
    }
}
