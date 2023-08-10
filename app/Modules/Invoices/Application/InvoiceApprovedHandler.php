<?php

declare(strict_types=1);


namespace App\Modules\Invoices\Application;


use App\Domain\Events\InvoiceApprovedInterface;
use App\Modules\Invoices\Domain\InvoiceNotFound;
use App\Modules\Invoices\Domain\InvoiceRepositoryInterface;

final class InvoiceApprovedHandler
{
    public function __construct(private readonly InvoiceRepositoryInterface $invoiceRepository)
    {
    }

    public function handle(InvoiceApprovedInterface $e): void
    {
        $invoice = $this->invoiceRepository->findOne($e->getId());

        if (!$invoice) {
            throw new InvoiceNotFound();
        }

        $invoice->approve();

        $this->invoiceRepository->store($invoice);
    }
}
