<?php

declare(strict_types=1);


namespace App\Modules\Invoices\Api;


use Illuminate\Foundation\Http\FormRequest;

final class ShowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|uuid|exists:invoices,id',
        ];
    }

    public function validationData()
    {
        return [
            'id' => $this->route('id'),
        ];
    }
}
