<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use App\Domain\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;

final class Invoice extends Model
{
    protected $fillable = [
        'status',
    ];

    public static function create(StatusEnum $status): self
    {
        return new self([
            'status' => $status->value,
        ]);
    }

    /** @throws InvoiceBadState */
    public function approve(): void
    {
        $actual = StatusEnum::from($this->getAttribute('status'));
        if (StatusEnum::DRAFT !== $actual) {
            throw new InvoiceBadState('Invoice must be in draft status, now is: ' . $actual->value);
        }
        $this->setAttribute('status', StatusEnum::APPROVED);
    }

    public function getStatus(): StatusEnum
    {
        return StatusEnum::from($this->getAttribute('status'));
    }

    /** @throws InvoiceBadState */
    public function reject(): void
    {
        $actual = StatusEnum::from($this->getAttribute('status'));
        if (StatusEnum::DRAFT !== $actual) {
            throw new InvoiceBadState('Invoice must be in draft status, now is: ' . $actual->value);
        }
        $this->setAttribute('status', StatusEnum::REJECTED);
    }
}
