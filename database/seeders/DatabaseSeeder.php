<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        Role::factory()->create([
            'name' => 'Company Admin',
            'slug' => 'company-admin',
        ]);

        Role::factory()->create([
            'name' => 'Company Member',
            'slug' => 'company-member',
        ]);

        User::factory()->create([
            'name' => 'George Vlisidis',
            'email' => 'gv@mail.com',
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Yas Thompson',
            'email' => 'yas@mail.com',
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Stephen Hanlon',
            'email' => 'stephen@mail.com',
            'role_id' => 1,
        ]);

       // User::factory(30)->create();

        $companies = Company::factory(10)->create();

        foreach ($companies as $company) {
            $company->users()->attach([1,2,3]);
            $userAdmin = User::factory()->create(['role_id' => 2]);
            $company->users()->attach($userAdmin);
            $userMembers = User::factory(rand(2,6))->create(['role_id' => 3]);
            $company->users()->attach($userMembers);
        }
    }
}
