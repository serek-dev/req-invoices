<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Domain\Events\InvoiceApprovedInterface;
use App\Domain\Events\InvoiceRejectedInterface;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Application\InvoiceApprovedHandler;
use App\Modules\Invoices\Application\InvoiceFacade;
use App\Modules\Invoices\Application\InvoiceRejectedHandler;
use App\Modules\Invoices\Application\ReadInvoiceQuery;
use App\Modules\Invoices\Domain\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Database\Repository\EloquentRepository;
use App\Modules\Invoices\Infrastructure\View\EloquentInvoiceQuery;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

final class InvoicesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoiceFacadeInterface::class, InvoiceFacade::class);
        $this->app->scoped(ReadInvoiceQuery::class, EloquentInvoiceQuery::class);
        $this->app->scoped(InvoiceRepositoryInterface::class, EloquentRepository::class);
    }

    public function boot(): void
    {
        Event::listen(InvoiceApprovedInterface::class, [InvoiceApprovedHandler::class, 'handle']);
        Event::listen(InvoiceRejectedInterface::class, [InvoiceRejectedHandler::class, 'handle']);
    }
}
