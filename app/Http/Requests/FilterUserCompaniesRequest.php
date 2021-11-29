<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterUserCompaniesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyIds = $this->user()->isAdmin()
            ? array_merge([0], auth()->user()->companies->pluck('id')->toArray())
            : auth()->user()->companies->pluck('id')->toArray();

        //dd($companyIds);
        return [
            'company_id' => [Rule::in($companyIds)],
        ];
    }
}
