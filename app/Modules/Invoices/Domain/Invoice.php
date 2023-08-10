<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use App\Domain\Enums\StatusEnum;

final class Invoice
{
    public function __construct(
        private StatusEnum $status
    ) {
    }

    /** @throws InvoiceBadState */
    public function approve(): void
    {
        if (StatusEnum::DRAFT !== $this->status) {
            throw new InvoiceBadState('Invoice must be in draft status.');
        }
        $this->status = StatusEnum::APPROVED;
    }
}
