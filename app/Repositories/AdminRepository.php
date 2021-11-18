<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;

class AdminRepository implements RepositoryInterface
{
    public function getUsers(User $user, string $companyId): array
    {
        $authUserCompanies = $user->companies();
        $company_id = 0;
        $users =  User::all();

        if ($companyId) {
            $company_id = $companyId;
            $users = $authUserCompanies->where('company_id', $companyId)->get()->first()->users;
        }

        return [
            'users' => UserResource::collection($users),
            'companies' => $user->companies()->get(),
            'company_id' => $company_id,
        ];
    }

}
