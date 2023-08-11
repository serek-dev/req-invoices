<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Repository;

use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\InvoiceRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final class EloquentRepository implements InvoiceRepositoryInterface
{
    public function findOne(UuidInterface $uuid): ?Invoice
    {
        return Invoice::where('id', $uuid)->first();
    }

    public function store(Invoice $invoice): void
    {
        $invoice->save();
    }
}
