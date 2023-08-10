<?php

declare(strict_types=1);


namespace App\Modules\Invoices\Domain;

use Ramsey\Uuid\UuidInterface;

interface InvoiceRepositoryInterface
{
    public function findOne(UuidInterface $uuid): ?Invoice;

    public function store(Invoice $invoice): void;
}
