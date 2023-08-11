<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Domain\Events\InvoiceRejectedInterface;
use App\Modules\Invoices\Domain\InvoiceBadState;
use App\Modules\Invoices\Domain\InvoiceNotFound;
use App\Modules\Invoices\Domain\InvoiceRepositoryInterface;

final class InvoiceRejectedHandler
{
    public function __construct(private InvoiceRepositoryInterface $invoiceRepository)
    {
    }

    /**
     * @throws InvoiceBadState
     * @throws InvoiceNotFound
     */
    public function handle(InvoiceRejectedInterface $e): void
    {
        $invoice = $this->invoiceRepository->findOne($e->getId());

        if (!$invoice) {
            throw new InvoiceNotFound();
        }

        $invoice->reject();

        $this->invoiceRepository->store($invoice);
    }
}
