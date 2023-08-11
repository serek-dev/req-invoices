<?php

declare(strict_types=1);

namespace App\Modules\Approval\Infrastructure\Providers;

use App\Modules\Approval\Api\Http\ApprovalController;
use App\Modules\Approval\Api\Http\RejectionController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class ApprovalsRoutesServiceProvider extends RouteServiceProvider
{
    public function boot(): void
    {
        $this->routes(function (): void {
            Route::patch('api/approvals/{id}/approve', [ApprovalController::class, '__invoke']);
            Route::patch('api/approvals/{id}/reject', [RejectionController::class, '__invoke']);
        });
    }
}
