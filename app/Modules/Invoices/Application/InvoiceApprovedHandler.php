<?php

declare(strict_types=1);


namespace App\Modules\Invoices\Application;


use App\Domain\Events\InvoiceApprovedInterface;
use App\Modules\Invoices\Domain\InvoiceNotFound;

final class InvoiceApprovedHandler
{
    public function handle(InvoiceApprovedInterface $e): void
    {
        throw new InvoiceNotFound();
    }
}
