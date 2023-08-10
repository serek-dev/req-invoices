<?php

declare(strict_types=1);


namespace Tests\Unit\Modules\Invoices\Application;


use App\Modules\Invoices\Application\InvoiceApprovedHandler;
use PHPUnit\Framework\TestCase;

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

        // Then I should see an error

        // When I handle it
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
