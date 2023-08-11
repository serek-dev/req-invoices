<?php

declare(strict_types=1);

namespace App\Modules\Approval\Api\Events;

use App\Domain\Enums\StatusEnum;
use App\Domain\Events\InvoiceApprovedInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use Ramsey\Uuid\UuidInterface;

final class EntityApproved implements InvoiceApprovedInterface
{
    public function __construct(
        public ApprovalDto $approvalDto
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->approvalDto->id;
    }

    public function getStatus(): StatusEnum
    {
        return $this->approvalDto->status;
    }
}
