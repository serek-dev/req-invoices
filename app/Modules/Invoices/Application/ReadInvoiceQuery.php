<?php

declare(strict_types=1);


namespace App\Modules\Invoices\Application;

use JsonSerializable;

interface ReadInvoiceQuery
{
    public function find(string $id): JsonSerializable;
}
