<?php
namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use JetBrains\PhpStorm\NoReturn;

class GoogleDriveService
{
    protected $client;
    protected $driveService;

    #[NoReturn] public function __construct($clientId, $clientSecret, $refreshToken)
    {
        $client = new Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setAccessType('offline');
        $client->fetchAccessTokenWithRefreshToken($refreshToken);
        $this->driveService = new Drive($client);
        $accessToken = $client->fetchAccessTokenWithRefreshToken($refreshToken);
        dd($accessToken);
    }

    public function uploadFile($filePath, $fileName, $folderId = null): string
    {
        $fileMetadata = new \Google\Service\Drive\DriveFile([
            'name' => $fileName,
            'parents' => $folderId ? [$folderId] : []
        ]);


        $content = file_get_contents($filePath);

        $file = $this->driveService->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => mime_content_type($filePath),
            'uploadType' => 'multipart',
            'fields' => 'id',
        ]);
        return $file->id;
    }

    public function getAuthorizationUrl($clientId, $clientSecret,$state): string
    {
        $client = new Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri('http://127.0.0.1:8000/api/google/drive/callback');
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $client->setIncludeGrantedScopes(true);
        $client->addScope(\Google_Service_Drive::DRIVE);
        $client->setState($state);

        return $client->createAuthUrl();
    }
}
