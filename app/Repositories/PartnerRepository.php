<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;

class PartnerRepository implements RepositoryInterface
{
    public function getUsers(User $user, string $companyId): array
    {
        $authUserCompanies = $user->companies();
        $defaultCompany = $authUserCompanies->first();
        $company_id = $defaultCompany->id;
        $users =  $defaultCompany->users;
        if($companyId) {
            $company_id = $companyId;
            $users = $authUserCompanies->where('company_id', $companyId)->get()->first()->users;
        }


        return [
            'users' => UserResource::collection($users),
            'companies' => $authUserCompanies->get(),
            'company_id' => $company_id,
        ];
    }
}
