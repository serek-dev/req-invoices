<?php

declare(strict_types=1);

namespace App\Modules\Approval\Api\Events;

use App\Domain\Events\InvoiceRejectedInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use Ramsey\Uuid\UuidInterface;

final readonly class EntityRejected implements InvoiceRejectedInterface
{
    public function __construct(
        public ApprovalDto $approvalDto
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->approvalDto->id;
    }
}
