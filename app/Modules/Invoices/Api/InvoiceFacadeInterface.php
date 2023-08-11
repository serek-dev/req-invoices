<?php

declare(strict_types=1);


namespace App\Modules\Invoices\Api;

use JsonSerializable;

interface InvoiceFacadeInterface
{
    public function findInvoice(string $id): JsonSerializable;
}
