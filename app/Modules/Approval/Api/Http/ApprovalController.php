<?php

declare(strict_types=1);


namespace App\Modules\Approval\Api\Http;

use App\Domain\Enums\StatusEnum;
use App\Infrastructure\Controller;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

final class ApprovalController extends Controller
{
    public function __invoke(ApprovalRequest $request, ApprovalFacadeInterface $facade): Response
    {
        $facade->approve(
            new ApprovalDto(
                Uuid::fromString($request->route('id')),
                StatusEnum::DRAFT,
                'invoice',
            )
        );

        return response()->json(status: Response::HTTP_ACCEPTED);
    }
}
