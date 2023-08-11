<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Read;

use Illuminate\Database\Eloquent\Model;

final class InvoiceReadModel extends Model
{
    public $incrementing = false;

    protected $table = 'invoices';

    protected $keyType = 'string';
}
