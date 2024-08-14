<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Http\Requests\TenantOnboardingRequest;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Role;
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
}
