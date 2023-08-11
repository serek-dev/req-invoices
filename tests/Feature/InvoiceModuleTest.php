<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Enums\StatusEnum;
use App\Domain\Events\InvoiceApprovedInterface;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\InvoiceBadState;
use App\Modules\Invoices\Infrastructure\Database\Seeders\InvoiceSeeder;
use Illuminate\Contracts\Events\Dispatcher;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Tests\CreatesApplication;
use Tests\TestCase;

final class InvoiceModuleTest extends TestCase
{
    use CreatesApplication;

    public function testApproveExistingInvoiceDraft(): void
    {
        // Given I have an event from the external thing
        // with UUID of an existing invoice in draft status
        $event = $this->getEvent();

        // When I execute my app
        $this->dispatch($event);

        // Then invoice should be approved
        /** @var ?Invoice $actual */
        $actual = Invoice::where('id', $event->getId())->first();
        $this->assertNotEmpty($actual);
        $this->assertEquals(StatusEnum::APPROVED, $actual->getStatus());
    }

    /** @depends testApproveExistingInvoiceDraft */
    public function testApproveFailsOnAlreadyApproved(): void
    {
        // Given I have an event for already approved invoice
        $event = $this->getEvent();

        // Then I should see an error
        $this->expectException(InvoiceBadState::class);

        // When trying to change status
        $this->dispatch($event);
    }

    private function dispatch(object $event): void
    {
        $app = $this->createApplication();
        $app->make(Dispatcher::class)->dispatch($event);
    }

    private function getEvent(): InvoiceApprovedInterface
    {
        return new class implements InvoiceApprovedInterface {
            public function getId(): UuidInterface
            {
                return Uuid::fromString(InvoiceSeeder::FIRST_DRAFT_INVOICE_ID);
            }
        };
    }
}
