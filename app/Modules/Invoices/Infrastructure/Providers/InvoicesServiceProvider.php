<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Domain\Events\InvoiceApprovedInterface;
use App\Modules\Invoices\Application\InvoiceApprovedHandler;
use App\Modules\Invoices\Domain\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Database\Repository\EloquentRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

final class InvoicesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(InvoiceApprovedInterface::class, [InvoiceApprovedHandler::class, 'handle']);

        $this->app->instance(InvoiceRepositoryInterface::class, new EloquentRepository());
    }
}
