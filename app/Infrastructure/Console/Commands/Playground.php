<?php

declare(strict_types=1);


namespace App\Infrastructure\Console\Commands;


use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

final class Playground extends Command
{
    protected $signature = 'app:test';

    public function __invoke(ApprovalFacadeInterface $facade)
    {
        $facade->approve(
            new ApprovalDto(
                Uuid::uuid4(),
                StatusEnum::DRAFT,
                'Invoice',
            )
        );
    }
}
