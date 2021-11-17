<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        return Inertia::render('Companies/CompanyIndex',[
            'companies' => CompanyResource::collection(Company::all())
        ]);
    }

    public function users(Company $company)
    {
        return Inertia::render('Users/UserIndex', [
            'users' => UserResource::collection($company->users)
        ]);
    }

    public function create()
    {
        return Inertia::render('Companies/CompanyCreate');
    }

    public function store(StoreCompanyRequest $request)
    {
        Company::create($request->validated());

        return redirect()->route('companies.index')->with('status', 'Company created successfully!');
    }

    public function edit(Company $company)
    {
        return Inertia::render('Companies/CompanyEdit', [
            'company' => new CompanyResource($company),
        ]);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return redirect()->route('companies.index')->with('status', 'Company updated successfully!');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')->with('status', 'Company deleted successfully!');
    }
}
