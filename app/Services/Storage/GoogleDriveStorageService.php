<?php

namespace App\Services\Storage;

use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Log;

class GoogleDriveStorageService
{
    protected $client;
    protected $driveService;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setScopes([Drive::DRIVE_FILE, Drive::DRIVE]);

        $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
        $this->client->setHttpClient($guzzleClient);

        $jsonPath = config('services.google.service_account_json');
        
        if ($jsonPath && file_exists($jsonPath)) {
            $this->client->setAuthConfig($jsonPath);
        }

        $this->driveService = new Drive($this->client);
    }

    /**
     * Get or create a folder by name under a parent folder.
     *
     * @param string $folderName
     * @param string|null $parentFolderId
     * @return string|null
     */
    public function getOrCreateFolder($folderName, $parentFolderId = null)
    {
        if (app()->environment('testing')) {
            return 'mock_folder_id_' . strtolower($folderName);
        }

        $parentFolder = $parentFolderId ?: (config('services.google.root_folder_id') ?: 'root');
        
        try {
            $parentQuery = $parentFolder ? " and '{$parentFolder}' in parents" : "";
            $q = "mimeType = 'application/vnd.google-apps.folder' and name = '{$folderName}' and trashed = false{$parentQuery}";
            
            $files = $this->searchFiles($q);
            if (count($files) > 0) {
                return $files[0]->id;
            }

            return $this->createFolder($folderName, $parentFolder);
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'File not found') !== false && $parentFolder !== 'root') {
                Log::warning("Configured root folder ID {$parentFolder} not found. Falling back to 'root'.");
                return $this->getOrCreateFolder($folderName, 'root');
            }
            Log::error("Google Drive getOrCreateFolder error for {$folderName}: " . $e->getMessage());
            return 'root';
        }
    }

    /**
     * Upload a document to a specific folder on Google Drive.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string|null $folderNameOrId
     * @return array|null
     */
    public function uploadDocument($file, $folderNameOrId = 'Resumes')
    {
        if (app()->environment('testing')) {
            return [
                'google_drive_file_id' => 'mock_google_drive_file_id_' . uniqid(),
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension(),
            ];
        }

        try {
            $fileMetadata = new Drive\DriveFile([
                'name' => $file->getClientOriginalName()
            ]);

            $targetFolderId = null;
            if ($folderNameOrId) {
                $standardFolders = ['Resumes', 'CoverLetters', 'Certificates', 'CompanyDocuments', 'EmployerAttachments', 'AdminFiles'];
                if (in_array($folderNameOrId, $standardFolders)) {
                    $targetFolderId = $this->getOrCreateFolder($folderNameOrId);
                } else {
                    $targetFolderId = $folderNameOrId;
                }
            } else {
                $targetFolderId = config('services.google.root_folder_id') ?: 'root';
            }

            if ($targetFolderId) {
                $fileMetadata->setParents([$targetFolderId]);
            }

            $content = file_get_contents($file->getRealPath());

            try {
                $uploadedFile = $this->driveService->files->create($fileMetadata, [
                    'data' => $content,
                    'mimeType' => $file->getClientMimeType(),
                    'uploadType' => 'multipart',
                    'fields' => 'id'
                ]);
            } catch (\Exception $ex) {
                if (strpos($ex->getMessage(), 'File not found') !== false && $targetFolderId !== 'root') {
                    Log::warning("Parent folder {$targetFolderId} not found during upload. Retrying to 'root'.");
                    $fileMetadata->setParents(['root']);
                    $uploadedFile = $this->driveService->files->create($fileMetadata, [
                        'data' => $content,
                        'mimeType' => $file->getClientMimeType(),
                        'uploadType' => 'multipart',
                        'fields' => 'id'
                    ]);
                } else {
                    throw $ex;
                }
            }

            return [
                'google_drive_file_id' => $uploadedFile->id,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension(),
            ];
        } catch (\Exception $e) {
            Log::error('Google Drive Upload Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Download document content from Google Drive by file ID.
     *
     * @param string $fileId
     * @return string|null
     */
    public function downloadDocument($fileId)
    {
        if (app()->environment('testing')) {
            return 'mock_document_content';
        }

        try {
            $response = $this->driveService->files->get($fileId, ['alt' => 'media']);
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error('Google Drive Download Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Replace document on Google Drive.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string|null $oldFileId
     * @param string|null $folderId
     * @return array|null
     */
    public function replaceDocument($file, $oldFileId, $folderId = null)
    {
        if ($oldFileId) {
            $this->deleteDocument($oldFileId);
        }
        return $this->uploadDocument($file, $folderId);
    }

    /**
     * Delete a document from Google Drive by file ID.
     *
     * @param string $fileId
     * @return bool
     */
    public function deleteDocument($fileId)
    {
        if (app()->environment('testing')) {
            return true;
        }

        try {
            $this->driveService->files->delete($fileId);
            return true;
        } catch (\Exception $e) {
            Log::error('Google Drive Delete Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a new folder on Google Drive.
     *
     * @param string $name
     * @param string|null $parentFolderId
     * @return string|null
     */
    public function createFolder($name, $parentFolderId = null)
    {
        if (app()->environment('testing')) {
            return 'mock_folder_id_' . uniqid();
        }

        try {
            $fileMetadata = new Drive\DriveFile([
                'name' => $name,
                'mimeType' => 'application/vnd.google-apps.folder'
            ]);

            $parentFolder = $parentFolderId ?: config('services.google.root_folder_id');
            if ($parentFolder) {
                $fileMetadata->setParents([$parentFolder]);
            }

            $folder = $this->driveService->files->create($fileMetadata, [
                'fields' => 'id'
            ]);

            return $folder->id;
        } catch (\Exception $e) {
            Log::error('Google Drive Create Folder Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get document metadata.
     *
     * @param string $fileId
     * @return array|null
     */
    public function getMetadata($fileId)
    {
        if (app()->environment('testing')) {
            return [
                'id' => $fileId,
                'name' => 'mock_file.pdf',
                'size' => 12345,
                'mimeType' => 'application/pdf',
            ];
        }

        try {
            $file = $this->driveService->files->get($fileId, ['fields' => 'id, name, size, mimeType, createdTime']);
            return [
                'id' => $file->id,
                'name' => $file->name,
                'size' => $file->size,
                'mimeType' => $file->mimeType,
                'created_time' => $file->createdTime,
            ];
        } catch (\Exception $e) {
            Log::error('Google Drive Get Metadata Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Search files on Google Drive.
     *
     * @param string $query
     * @return array
     */
    public function searchFiles($query)
    {
        if (app()->environment('testing')) {
            return [];
        }

        try {
            $response = $this->driveService->files->listFiles([
                'q' => $query,
                'fields' => 'files(id, name, size, mimeType)'
            ]);
            return $response->getFiles();
        } catch (\Exception $e) {
            Log::error('Google Drive Search Error: ' . $e->getMessage());
            return [];
        }
    }
}
