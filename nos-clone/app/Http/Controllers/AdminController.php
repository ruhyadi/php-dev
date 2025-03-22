<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AdminController as ApiAdminController;
use Carbon\Carbon;

class AdminController extends Controller
{
    protected $apiAdminController;

    public function __construct(ApiAdminController $apiAdminController)
    {
        $this->apiAdminController = $apiAdminController;
    }

    public function dashboard()
    {
        $apiResponse = $this->apiAdminController->getUsers();
        $responseData = json_decode($apiResponse->getContent(), true);
        
        // Create User models from the API response
        $users = collect($responseData['data'])->map(function ($userData) {
            $user = new User();
            $user->forceFill([
                'id' => $userData['id'],
                'name' => $userData['name'],
                'email' => $userData['email'],
                'created_at' => Carbon::parse($userData['created_at']),
                'updated_at' => Carbon::parse($userData['updated_at'])
            ]);
            $user->exists = true;

            // Create Role model and set the relationship
            $role = new Role();
            $role->forceFill($userData['role']);
            $role->exists = true;
            $user->setRelation('role', $role);
            
            return $user;
        });
        
        return view('admin.dashboard', ['users' => $users]);
    }

    public function showUser($id)
    {
        $apiResponse = $this->apiAdminController->getUser($id);
        $responseData = json_decode($apiResponse->getContent(), true);

        if ($apiResponse->getStatusCode() !== 200) {
            return redirect()->route('admin.dashboard')
                ->with('error', $responseData['message']);
        }

        // Convert user data to User model
        $userData = $responseData['data']['user'];
        $user = new User();
        $user->forceFill([
            'id' => $userData['id'],
            'name' => $userData['name'],
            'email' => $userData['email'],
            'created_at' => Carbon::parse($userData['created_at']),
            'updated_at' => Carbon::parse($userData['updated_at'])
        ]);
        $user->exists = true;

        // Set role relationship
        if (isset($userData['role'])) {
            $role = new Role();
            $role->forceFill($userData['role']);
            $role->exists = true;
            $user->setRelation('role', $role);
        }

        // Convert roles to Role models
        $roles = collect($responseData['data']['roles'])->map(function ($roleData) {
            $role = new Role();
            $role->forceFill($roleData);
            $role->exists = true;
            return $role;
        });

        return view('admin.users.show', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function editUser($id)
    {
        $apiResponse = $this->apiAdminController->getUser($id);
        $responseData = json_decode($apiResponse->getContent(), true);

        if ($apiResponse->getStatusCode() !== 200) {
            return redirect()->route('admin.dashboard')
                ->with('error', $responseData['message']);
        }

        // Convert user data to User model
        $userData = $responseData['data']['user'];
        $user = new User();
        $user->forceFill([
            'id' => $userData['id'],
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role_id' => $userData['role']['id'],
            'created_at' => Carbon::parse($userData['created_at']),
            'updated_at' => Carbon::parse($userData['updated_at'])
        ]);
        $user->exists = true;

        // Set role relationship
        if (isset($userData['role'])) {
            $role = new Role();
            $role->forceFill($userData['role']);
            $role->exists = true;
            $user->setRelation('role', $role);
        }

        // Convert roles to Role models
        $roles = collect($responseData['data']['roles'])->map(function ($roleData) {
            $role = new Role();
            $role->forceFill($roleData);
            $role->exists = true;
            return $role;
        });

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $apiResponse = $this->apiAdminController->updateUser($request, $id);
        $responseData = json_decode($apiResponse->getContent(), true);

        if ($apiResponse->getStatusCode() !== 200) {
            return back()
                ->withErrors($responseData['errors'] ?? ['error' => $responseData['message']])
                ->withInput();
        }

        return redirect()->route('admin.users.show', $id)
            ->with('success', $responseData['message']);
    }

    public function deleteUser($id)
    {
        $apiResponse = $this->apiAdminController->deleteUser($id);
        $responseData = json_decode($apiResponse->getContent(), true);

        if ($apiResponse->getStatusCode() !== 200) {
            return back()->with('error', $responseData['message']);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', $responseData['message']);
    }
}