<?php

namespace App\Repositories;

use App\Models\User;
use phpDocumentor\Reflection\Types\This;

class RepositoryFactory
{
     protected array $repositories = [
        'admin' => AdminRepository::class,
        'company-admin' => PartnerRepository::class,
    ];

    public function make(User $user)
    {
        if (in_array($user->role->slug, $this->repositories)) {
            return new $this->repositories['$user->role->slug']();
        }

        throw new \Exception();
    }
}
