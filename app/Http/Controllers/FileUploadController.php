<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Models\Attachment;
use App\Models\TenantSettings;
use App\Services\GoogleDriveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

class FileUploadController extends Controller
{
    public function uploadFile(UploadFileRequest $request): JsonResponse
    {
        $tenantId = auth()->user()->tenant_id; // assuming tenant is associated with the user
        $tenantSettings = TenantSettings::where('tenant_id', $tenantId)->get()->pluck('setting_value', 'setting_key');

        $clientId = Crypt::decryptString($tenantSettings['google_drive_client_id']);
        $clientSecret = Crypt::decryptString($tenantSettings['google_drive_client_secret']);
        $refreshToken = $tenantSettings['google_drive_refresh_token']; // store refresh token as well
        $googleDriveService = new GoogleDriveService($clientId, $clientSecret, $refreshToken);

        $file = $request->file('file');
        $folderId = 'junk'; // specify folder ID based on module
        $fileId = $googleDriveService->uploadFile($file->getPathname(), $file->getClientOriginalName(), $folderId);

        Attachment::create([
            'tenant_id' => $tenantId,
            'related_entity_type' => $request->related_entity_type,
            'related_entity_id' => $request->related_entity_id,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
            'file_url' => 'https://drive.google.com/uc?id=' . $fileId,
            'uploaded_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'File uploaded successfully']);
    }
}
