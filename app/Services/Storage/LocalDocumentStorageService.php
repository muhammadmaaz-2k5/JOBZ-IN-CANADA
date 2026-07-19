<?php

namespace App\Services\Storage;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LocalDocumentStorageService
{
    /**
     * Upload a document to a specific folder on the local private disk.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folderName
     * @return array|null
     */
    public function uploadDocument($file, $folderName = 'Resumes')
    {
        try {
            $dir = Str::snake($folderName);
            $path = $file->store($dir, 'private');

            return [
                'google_drive_file_id' => null,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension(),
            ];
        } catch (\Exception $e) {
            Log::error('Local Document Upload Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Download document content from the local private disk by file path.
     *
     * @param string $filePath
     * @return string|null
     */
    public function downloadDocument($filePath)
    {
        try {
            if (Storage::disk('private')->exists($filePath)) {
                return Storage::disk('private')->get($filePath);
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Local Document Download Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Replace document on the local private disk.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string|null $oldFilePath
     * @param string $folderName
     * @return array|null
     */
    public function replaceDocument($file, $oldFilePath, $folderName = 'Resumes')
    {
        if ($oldFilePath) {
            $this->deleteDocument($oldFilePath);
        }
        return $this->uploadDocument($file, $folderName);
    }

    /**
     * Delete a document from the local private disk by file path.
     *
     * @param string $filePath
     * @return bool
     */
    public function deleteDocument($filePath)
    {
        try {
            if (Storage::disk('private')->exists($filePath)) {
                return Storage::disk('private')->delete($filePath);
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Local Document Delete Error: ' . $e->getMessage());
            return false;
        }
    }
}
