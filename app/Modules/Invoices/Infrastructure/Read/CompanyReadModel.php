<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Read;

use Illuminate\Database\Eloquent\Model;

final class CompanyReadModel extends Model
{
    public $incrementing = false;

    protected $table = 'companies';

    protected $keyType = 'string';
}
