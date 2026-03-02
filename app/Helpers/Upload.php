<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadTrait;

class Upload
{
    use UploadTrait;

    /*======================================================================
     * CONSTANTS
     *======================================================================*/

    const DISK_LOCAL = 'local';
    const DISK_DEFAULT = 'public'; // default
    const DISK_S3 = 's3';

    const TEMP_DIR_DATE_FORMAT = 'Y-m-d';
    const PNG_IMGTYPE = 'png';

    /*======================================================================
     * STATIC METHODS
     *======================================================================*/

    /**
     * Upload::saveTemp($file, $path, $filename, $disk)
     *
     * @param File $file
     * @param String $fileType
     * @param App\Helpers\Upload::DISK_/String $disk
     *
     * @return Bool/String $rtn - return false or path/url
     */
    public static function saveTemp($file, string $fileType = null, string $disk = 'public')
    {
        $rtn = false;

        if (!empty($file)) {
            try {
                self::tmpResourcesDump();
                $user = auth()->guard('api')->user() ? : auth()->user();

                $path = 'tmp/' . Carbon::now()->format(self::TEMP_DIR_DATE_FORMAT) . '/' . $user->id . '/' . $fileType;

                $saved = Storage::disk($disk)->put($path, $file);

                if ($saved) {
                    $rtn = Storage::disk($disk)->url($saved);
                }
            } catch (\Error $e) {
                \Log::error($e->getMessage());
            }
        }

        return $rtn;
    }

    /**
     * Upload::saveFromUrl($url, $path, $filename, $extension, $disk, $rtnType)
     * save file from url to specific application disk (local, public, s3)
     *
     * @param String $url
     * @param String $path
     * @param String $filename
     * @param String $extension
     * @param String $disk
     * @param String $rtnType
     * @return Bool/String $rtn - false/url path/path
     */
    public static function saveFromUrl(string $url, string $path = null, string $filename = null, string $extension = null, string $disk = null, string $rtnType = null)
    {
        $rtn = false;

        if (!static::isValidUrlString($url)) {
            \Log::error('Invalid url from string "' . $url . '"');
        } else {
            if (static::isUrlOwnedS3($url)) {
                // $rtn = self::saveS3($file, $path, $filename, $extension, $rtnType);
            } elseif (strpos($url, 'storage/') !== false) {
                $curPath = explode('storage/', $url)[1];
                $uploadedFile = static::getUploadedFileFromStoragePath($curPath);

                if ($uploadedFile) {
                    $rtn = self::save($uploadedFile, $path, $filename, $extension, $disk, $rtnType);
                }
            } else {
                // TODO: for external url saving (other than application files url & s3 bucket url)
            }
        }

        return $rtn;
    }

    public static function saveFromContentString(String $content, String $path = null, String $disk = null)
    {
        $rtn = [];

        preg_match_all('/<img[^>]+src="([^">]+)"/', $content, $imageUrls);

        foreach ($imageUrls[1] as $url) {
            try {
                $isValidUrlPublic = filter_var($url, FILTER_VALIDATE_URL)
                    && parse_url($url)['host'] == parse_url(config('app.url'))['host']
                    && Storage::disk(self::DISK_DEFAULT)->has(explode('/storage', $url)[1]);

                if ($isValidUrlPublic) {
                    self::tmpResourcesDump();
                    $tmpfullPath = explode('/storage', $url)[1];
                    $tmpFile = new File('storage/' . $tmpfullPath);
                    $file = new UploadedFile(
                        $tmpFile->getPathname(),
                        $tmpFile->getFilename(),
                        $tmpFile->getMimeType(),
                        0,
                        true // Set test mode to true
                    );
                    $filename = $file->getClientOriginalName();
                    $rtn[] = Upload::saveFromUrl($url, $path, $filename, null, $disk, null);
                }
            } catch (\Error $e) {
                \Log::error($e->getMessage());
            }
        }

        return $rtn;
    }

    /**
     * This function returns image url
     *
     * @param UploadedFile $file
     * @param String $filename
     * @param String $path
     * @param String $disk
     *
     * @return boolean|string $rtn - return the uploaded Url
     */
    public static function save(UploadedFile $file, String $filename = null, String $path = null, String $disk = null)
    {
        $rtn = false;

        $user = auth()->guard('api')->user() ? : auth()->user();

        if (is_null($filename))
            $filename = (Carbon::now()->timestamp + rand(2, 100)) . '.' . $file->getExtension();

        if (is_null($path))
            $path = Carbon::now()->format(self::TEMP_DIR_DATE_FORMAT) . '/' . $user->id;

        if (is_null($disk))
            $disk = self::DISK_DEFAULT;

        $path = $path . '/' . explode('/', $file->getMimeType())[0];
        $saved = Storage::disk($disk)->putFileAs($path, $file, $filename);

        if ($saved) {
            $storagePath = Storage::disk($disk)->path($saved);
            $rtn = static::getQualifiedPublicPath($storagePath);
        }

        return $rtn;
    }

    /*======================================================================
     * PRIVATE STATIC METHODS
     *======================================================================*/

    /**
     * Upload::tmpResourcesDump($disk)
     * Dump all temporary folder which is 2 days old and above
     *
     * @param App\Helpers\Upload::DISK_/String $disk - disk type of the folder
     * @return void
     */
    private static function tmpResourcesDump($disk = null)
    {
        if (is_null($disk)) {
            $disk = self::DISK_DEFAULT;
        }

        $dirs = Storage::disk($disk)->directories('tmp');

        // check to see if more than 2 temporary directory exist means:
        // (today will not be deleted, yesterday will not be deleted, then before yesterday will be deleted)
        if (count($dirs) > 2) {
            $validDir = [
                Carbon::now()->format(self::TEMP_DIR_DATE_FORMAT),
                Carbon::now()->addDays(-1)->format(self::TEMP_DIR_DATE_FORMAT)
            ];

            foreach ($dirs as $dir) {
                if (!in_array(explode('tmp/', $dir)[1], $validDir)) {
                    \Log::info('Temporary storage folder "' . $dir . '" is deleted. Note: folders 2 days old and above will be deleted.');
                    Storage::disk($disk)->deleteDirectory($dir);
                }
            }
        }
    }
}
