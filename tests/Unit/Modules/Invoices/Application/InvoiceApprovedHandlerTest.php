<?php

declare(strict_types=1);


namespace Tests\Unit\Modules\Invoices\Application;


use App\Domain\Events\InvoiceApprovedInterface;
use App\Modules\Invoices\Application\InvoiceApprovedHandler;
use App\Modules\Invoices\Domain\InvoiceNotFound;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/** @covers \App\Modules\Invoices\Application\InvoiceApprovedHandler */
final class InvoiceApprovedHandlerTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new InvoiceApprovedHandler();
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
        $sut = new InvoiceApprovedHandler();
        $sut->handle($event);
    }

    public function testHandleOnInvalidStatusThrowsError(): void
    {
        // Given I have an existing event

        // But it's not draft status

        // Then I should see an error

        // When I handle it
    }

    public function testHandle(): void
    {
        // Given I have an existing event

        // And it is in draft status

        // Then it should be persisted correctly

        // When I handle it
    }
}
