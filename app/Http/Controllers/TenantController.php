<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Http\Requests\TenantOnboardingRequest;
use App\Http\Requests\UpdateGoogleDriveSettingsRequest;
use App\Models\Tenant;
use App\Models\TenantSettings;
use App\Models\User;
use App\Models\Role;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class TenantController extends Controller
{
    use ApiResponse;

    public function onboard(TenantOnboardingRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Create the Tenant
            $tenant = Tenant::create([
                'name' => $request->tenant_name,
                'domain' => $request->domain, // Assuming 'domain' is part of the request
                'contact_email' => $request->contact_email, // Assuming 'contact_email' is part of the request
            ]);

            // Retrieve the admin role, or create it if it doesn't exist
            $adminRole = Role::firstOrCreate(
                ['name' => 'admin', 'tenant_id' => $tenant->id],
                ['permissions' => []] // You can define default permissions here
            );

            // Create the Admin User for the Tenant
            $admin = User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->password),
                'tenant_id' => $tenant->id,
                'role_id' => $adminRole->id, // Assigning the admin role to the user
            ]);

            // Generate an authentication token for the admin user
            $token = $admin->createToken('auth_token')->plainTextToken;

            DB::commit();

            return $this->success([
                'tenant' => $tenant,
                'admin' => $admin,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 'Tenant onboarded successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error for debugging purposes
            \Log::error('Tenant onboarding failed: ' . $e->getMessage());

            return $this->error('Onboarding failed: ' . $e->getMessage(), 500);
        }
    }

    public function updateGoogleDriveSettings(UpdateGoogleDriveSettingsRequest $request): JsonResponse
    {


        $tenantId = Auth::user()->tenant_id;

        // Encrypt the client ID and secret
        $encryptedClientId = Crypt::encryptString($request->input('google_drive_client_id'));
        $encryptedClientSecret = Crypt::encryptString($request->input('google_drive_client_secret'));

        // Update or create the tenant settings
        TenantSettings::updateOrCreate(
            ['tenant_id' => $tenantId, 'setting_key' => 'google_drive_client_id'],
            ['setting_value' => $encryptedClientId]
        );

        TenantSettings::updateOrCreate(
            ['tenant_id' => $tenantId, 'setting_key' => 'google_drive_client_secret'],
            ['setting_value' => $encryptedClientSecret]
        );

        return response()->json(['message' => 'Google Drive settings updated successfully']);
    }

    public function authorizeGoogleDrive(): JsonResponse
    {
        $tenantId = auth()->user()->tenant_id;
        $tenantSettings = TenantSettings::where('tenant_id', $tenantId)->get()->pluck('setting_value', 'setting_key');

        $clientId = Crypt::decryptString($tenantSettings['google_drive_client_id']);
        $clientSecret = Crypt::decryptString($tenantSettings['google_drive_client_secret']);

        $googleDriveService = new GoogleDriveService($clientId, $clientSecret, '');

        $state = base64_encode(json_encode(['tenant_id' => $tenantId]));

        return response()->json([
            'authorization_url' => $googleDriveService->getAuthorizationUrl($clientId, $clientSecret, $state),
        ], 200);
    }

    public function handleCallback(Request $request): JsonResponse
    {
        $code = $request->input('code');
        $state = $request->input('state');
        $decodedState = json_decode(base64_decode($state), true);
        $tenantId = $decodedState['tenant_id'] ?? null;

        if (empty($code) || empty($tenantId)) {
            return $this->error('Authorization code not provided.', 400);
        }

        TenantSettings::updateOrCreate(
            ['tenant_id' => $tenantId, 'setting_key' => 'google_drive_refresh_token'],
            ['setting_value' => $code]
        );

        return $this->success([], 'Google Drive authorized successfully.');

    }
}
