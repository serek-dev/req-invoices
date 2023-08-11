<?php

declare(strict_types=1);


namespace App\Modules\Invoices\Application;


use JsonSerializable;

final class InvoiceFacade
{
    public function __construct(private readonly ReadInvoiceQuery $query)
    {
    }

    public function findInvoice(string $id): JsonSerializable
    {
        return $this->query->find($id);
    }
}
