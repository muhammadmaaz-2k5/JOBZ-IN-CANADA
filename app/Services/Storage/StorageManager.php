<?php

namespace App\Services\Storage;

class StorageManager
{
    protected $cloudinary;
    protected $googleDrive;
    protected $localDocument;

    public function __construct(
        CloudinaryStorageService $cloudinary,
        GoogleDriveStorageService $googleDrive,
        LocalDocumentStorageService $localDocument
    ) {
        $this->cloudinary = $cloudinary;
        $this->googleDrive = $googleDrive;
        $this->localDocument = $localDocument;
    }

    /**
     * Get Cloudinary storage service.
     *
     * @return CloudinaryStorageService
     */
    public function cloudinary()
    {
        return $this->cloudinary;
    }

    /**
     * Get document/drive storage service.
     *
     * @return GoogleDriveStorageService|LocalDocumentStorageService
     */
    public function drive()
    {
        $driver = config('services.google.document_driver', 'local');
        
        if ($driver === 'google') {
            return $this->googleDrive;
        }

        return $this->localDocument;
    }
}
