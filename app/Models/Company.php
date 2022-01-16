<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    const ADMIN = 1;
    const COMPANY_ADMIN = 2;
    const COMPANY_MEMBER = 3;

    const roles = [
        'admin' => self::ADMIN,
        'company_admin' => self::COMPANY_ADMIN,
        'company_member' => self::COMPANY_MEMBER,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(CompanyUser::class);
    }
}
