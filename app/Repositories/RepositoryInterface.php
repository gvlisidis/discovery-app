<?php

namespace App\Repositories;

use App\Models\User;

interface RepositoryInterface
{
    public function getUsers(User $user, string $companyId): array;
}
