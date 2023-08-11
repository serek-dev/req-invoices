<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Enums\StatusEnum;
use App\Domain\Events\InvoiceApprovedInterface;
use App\Domain\Events\InvoiceRejectedInterface;
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
        $event = $this->getApprovalEvent(InvoiceSeeder::FIRST_DRAFT_INVOICE_ID);

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
        $event = $this->getApprovalEvent(InvoiceSeeder::FIRST_DRAFT_INVOICE_ID);

        // Then I should see an error
        $this->expectException(InvoiceBadState::class);

        // When trying to change status
        $this->dispatch($event);
    }

    public function testRejectExistingInvoiceDraft(): void
    {
        // Given I have an event from the external thing
        // with UUID of an existing invoice in draft status
        $event = $this->getRejectionEvent(InvoiceSeeder::SECOND_DRAFT_INVOICE_ID);

        // When I execute my app
        $this->dispatch($event);

        // Then invoice should be rejected
        /** @var ?Invoice $actual */
        $actual = Invoice::where('id', $event->getId())->first();
        $this->assertNotEmpty($actual);
        $this->assertEquals(StatusEnum::REJECTED, $actual->getStatus());
    }

    /** @depends testRejectExistingInvoiceDraft */
    public function testRejectFailsOnAlreadyRejected(): void
    {
        // Given I have an event for already rejected invoice
        $event = $this->getRejectionEvent(InvoiceSeeder::SECOND_DRAFT_INVOICE_ID);

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

    private function getApprovalEvent(string $uuid): InvoiceApprovedInterface
    {
        return new class ($uuid) implements InvoiceApprovedInterface {
            public function __construct(private string $uuid)
            {
            }

            public function getId(): UuidInterface
            {
                return Uuid::fromString($this->uuid);
            }
        };
    }

    private function getRejectionEvent(string $uuid): InvoiceRejectedInterface
    {
        return new class ($uuid) implements InvoiceRejectedInterface {
            public function __construct(private string $uuid)
            {
            }

            public function getId(): UuidInterface
            {
                return Uuid::fromString($this->uuid);
            }
        };
    }
}
