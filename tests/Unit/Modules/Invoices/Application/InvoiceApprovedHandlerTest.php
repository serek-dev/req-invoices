<?php

declare(strict_types=1);


namespace Tests\Unit\Modules\Invoices\Application;


use App\Domain\Events\InvoiceApprovedInterface;
use App\Modules\Invoices\Application\InvoiceApprovedHandler;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\InvoiceBadState;
use App\Modules\Invoices\Domain\InvoiceNotFound;
use App\Modules\Invoices\Domain\InvoiceRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/** @covers \App\Modules\Invoices\Application\InvoiceApprovedHandler */
final class InvoiceApprovedHandlerTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new InvoiceApprovedHandler(
            $this->createMock(InvoiceRepositoryInterface::class)
        );
        $this->assertInstanceOf(InvoiceApprovedHandler::class, $sut);
    }

    public function testHandleNonExistingInvoiceThrowsError(): void
    {
        // Given I have an event with non-existing uuid
        $event = $this->createMock(InvoiceApprovedInterface::class);
        $event->method('getId')->willReturn(Uuid::uuid4());

        // Then I should see an error
        $this->expectException(InvoiceNotFound::class);

        // When I handle it
        $sut = new InvoiceApprovedHandler(
            $this->createMock(InvoiceRepositoryInterface::class)
        );
        $sut->handle($event);
    }

    public function testHandleOnInvalidStatusThrowsError(): void
    {
        // Given I have an existing event
        $event = $this->createMock(InvoiceApprovedInterface::class);
        $event->method('getId')->willReturn(Uuid::uuid4());

        // But it's not draft status
        $invoice = new Invoice();
        $repository = $this->createMock(InvoiceRepositoryInterface::class);
        $repository->method('findOne')
            ->willReturn($invoice);

        // Then I should see an error
        $this->expectException(InvoiceBadState::class);

        // When I handle it
        $sut = new InvoiceApprovedHandler($repository);
        $sut->handle($event);
    }

    public function testHandle(): void
    {
        // Given I have an existing event

        // And it is in draft status

        // Then it should be persisted correctly

        // When I handle it
    }
}
