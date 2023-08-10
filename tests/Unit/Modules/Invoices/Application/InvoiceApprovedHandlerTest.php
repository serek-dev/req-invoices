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
}
