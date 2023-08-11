<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Read;

use Illuminate\Database\Eloquent\Model;

final class ProductLineReadModel extends Model
{
    public $incrementing = false;

    protected $table = 'invoice_product_lines';

    protected $keyType = 'string';
}
