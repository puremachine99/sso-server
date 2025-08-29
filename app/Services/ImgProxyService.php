<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImgProxyService
{
    protected $baseUrl;
    protected $key;
    protected $salt;
    protected $enabled;

    public function __construct()
    {
        $this->baseUrl = config('imgproxy.url');
        $this->key = config('imgproxy.key');
        $this->salt = config('imgproxy.salt');
        $this->enabled = config('imgproxy.enabled');
    }

    /**
     * Generate imgproxy URL
     */
    public function url(string $imageUrl, array $options = []): string
    {
        if (!$this->enabled || empty($this->baseUrl)) {
            return $imageUrl; // Fallback ke URL asli jika imgproxy tidak aktif
        }

        $path = $this->buildPath($imageUrl, $options);
        
        return $this->baseUrl . '/' . $path;
    }

    /**
     * Build the imgproxy path without signing (for development)
     */
    protected function buildPath(string $imageUrl, array $options): string
    {
        $processingOptions = $this->buildProcessingOptions($options);
        $encodedUrl = $this->encodeUrl($imageUrl);

        return "{$processingOptions}/{$encodedUrl}";
    }

    /**
     * Encode URL for imgproxy (base64 URL safe)
     */
    protected function encodeUrl(string $url): string
    {
        return rtrim(strtr(base64_encode($url), '+/', '-_'), '=');
    }

    /**
     * Build processing options string
     */
    protected function buildProcessingOptions(array $options): string
    {
        $optionsString = '';

        // Resize options
        if (isset($options['width']) || isset($options['height'])) {
            $width = $options['width'] ?? '';
            $height = $options['height'] ?? '';
            $resizingType = $options['resizing_type'] ?? 'fit';
            $optionsString .= "/resize:{$resizingType}:{$width}:{$height}";
        }

        // Gravity (crop position)
        if (isset($options['gravity'])) {
            $optionsString .= "/gravity:{$options['gravity']}";
        }

        // Quality
        if (isset($options['quality'])) {
            $optionsString .= "/quality:{$options['quality']}";
        }

        // Format
        if (isset($options['format'])) {
            $optionsString .= "/format:{$options['format']}";
        }

        // Blur
        if (isset($options['blur'])) {
            $optionsString .= "/blur:{$options['blur']}";
        }

        // Trim
        if (isset($options['trim'])) {
            $optionsString .= "/trim:{$options['trim']}";
        }

        return ltrim($optionsString, '/');
    }

    /**
     * Generate URL for common use cases
     */
    public function resize(string $imageUrl, int $width, int $height, string $resizingType = 'fit'): string
    {
        return $this->url($imageUrl, [
            'width' => $width,
            'height' => $height,
            'resizing_type' => $resizingType
        ]);
    }

    public function thumbnail(string $imageUrl, int $size): string
    {
        return $this->url($imageUrl, [
            'width' => $size,
            'height' => $size,
            'resizing_type' => 'fill',
            'gravity' => 'ce'
        ]);
    }

    public function format(string $imageUrl, string $format, int $quality = 80): string
    {
        return $this->url($imageUrl, [
            'format' => $format,
            'quality' => $quality
        ]);
    }
} 