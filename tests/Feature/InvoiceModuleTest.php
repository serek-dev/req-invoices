<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Enums\StatusEnum;
use App\Domain\Events\InvoiceApprovedInterface;
use App\Modules\Invoices\Domain\Invoice;
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
        $app = $this->createApplication();

        // Given I have an event from the external thing
        // with UUID of an existing invoice in draft status
        $event = $this->getEvent();

        // When I execute my app
        $app->make(Dispatcher::class)->dispatch($event);

        // Then invoice should be approved
        /** @var ?Invoice $actual */
        $actual = Invoice::where('id', $event->getId())->first();
        $this->assertNotEmpty($actual);
        $this->assertEquals(StatusEnum::APPROVED, $actual->getStatus());
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
