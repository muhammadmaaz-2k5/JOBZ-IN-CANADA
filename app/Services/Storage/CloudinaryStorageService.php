<?php

namespace App\Services\Storage;

class CloudinaryStorageService
{
    /**
     * Upload an image to a folder on Cloudinary.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return array|null
     */
    public function uploadImage($file, $folder)
    {
        return \App\Services\CloudinaryService::upload($file, $folder);
    }

    /**
     * Delete an image from Cloudinary by public ID.
     *
     * @param string $publicId
     * @return bool
     */
    public function deleteImage($publicId)
    {
        return \App\Services\CloudinaryService::delete($publicId);
    }

    /**
     * Replace an image on Cloudinary.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string|null $oldPublicId
     * @param string $folder
     * @return array|null
     */
    public function replaceImage($file, $oldPublicId, $folder)
    {
        if ($oldPublicId) {
            $this->deleteImage($oldPublicId);
        }
        return $this->uploadImage($file, $folder);
    }

    /**
     * Generate dynamic transformation URLs.
     *
     * @param string $publicId
     * @param array $transformations
     * @return string
     */
    public function optimizeImage($publicId, $transformations = [])
    {
        $cloudName = config('services.cloudinary.cloud_name');
        $transPath = count($transformations) > 0 ? implode(',', $transformations) . '/' : '';
        return "https://res.cloudinary.com/{$cloudName}/image/upload/{$transPath}{$publicId}";
    }
}
