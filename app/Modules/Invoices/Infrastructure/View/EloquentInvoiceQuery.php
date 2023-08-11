<?php

declare(strict_types=1);


namespace App\Modules\Invoices\Infrastructure\View;


use App\Modules\Invoices\Application\ReadInvoiceQuery;
use JsonSerializable;

final class EloquentInvoiceQuery implements ReadInvoiceQuery
{
    public function find(string $id): JsonSerializable
    {
        return InvoiceReadModel::where('id', $id)->firstOrFail();
    }
}
