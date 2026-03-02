<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

trait UploadTrait
{
    /**
     * self::isUrlOwnedS3($url)
     * check if url is from own applicatino s3 bucket
     *
     * @param String $url
     * @return Bool true/false
     */
    public static function isUrlOwnedS3(string $url): bool
    {
        // return self::isUrlS3($url) && self::isUrlPattern($url, strtolower(env('AWS_BUCKET')));
        return false;
    }


    /**
     * Checks if a given string is a valid URL.
     *
     * @param string $url The URL to validate
     *
     * @return bool True if the string is a valid URL, false otherwise
     */
    public static function isValidUrlString(string $url): bool
    {
        $url = trim($url); // Remove leading/trailing spaces

        // Use parse_url to extract URL components
        $urlComponents = parse_url($url);

        // Check if the URL has at least a scheme (protocol) and a host
        if (
            isset($urlComponents['scheme']) &&
            isset($urlComponents['host']) &&
            in_array($urlComponents['scheme'], ['http', 'https'], true)
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get the uploaded file from storage path.
     *
     * @param string
     *
     * @return boolean
     */
    public static function getUploadedFileFromStoragePath($storagePath, $originalName = null, $mimeType = null)
    {
        $rtn = false;

        $storagePath = Storage::disk('public')->path($storagePath);

        if (file_exists($storagePath)) {
            $file = new File($storagePath);
            $rtn = static::convertFileToUploadedFile($file);
        }

        return $rtn;
    }

    /**
     * Convert file to uploaded file.
     *
     * @param string $url
     *
     * @return bool True if the string is a valid URL, false otherwise
     */
    public static function convertFileToUploadedFile(File $file, $originalName = null, $mimeType = null)
    {
        $originalName = $originalName ?: $file->getFilename();
        $mimeType = $mimeType ?: mime_content_type($file->getPathname());

        $uploadedFile = new UploadedFile(
            $file->getPathname(),
            $originalName,
            $mimeType,
            null,
            true // Set test mode to true
        );

        return UploadedFile::createFromBase($uploadedFile);
    }

    /**
     * Get the qualified public path.
     *
     * @param string $storagePath
     *
     * @return bool|string
     */
    public static function getQualifiedPublicPath(string $storagePath)
    {
        // Remove the '/app/public' prefix
        $path = str_replace('/app/public', '', $storagePath);

        // Use the base URL from the config instead of hardcoding '/var/www/html/'
        $baseUrl = config('app.url');
        $path = str_replace('/var/www/html/', $baseUrl, $path);

        return $path;
    }
}
