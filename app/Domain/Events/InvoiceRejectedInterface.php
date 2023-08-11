<?php

declare(strict_types=1);


namespace App\Domain\Events;

use Ramsey\Uuid\UuidInterface;

interface InvoiceRejectedInterface
{
    public function getId(): UuidInterface;
}
