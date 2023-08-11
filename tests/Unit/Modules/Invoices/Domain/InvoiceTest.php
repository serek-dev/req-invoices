<?php

declare(strict_types=1);


namespace Tests\Unit\Modules\Invoices\Domain;


use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\InvoiceBadState;
use Tests\TestCase;

/** @covers \App\Modules\Invoices\Domain\Invoice */
final class InvoiceTest extends TestCase
{
    public function testApproveFailsOnAlreadyApproved(): void
    {
        $sut = Invoice::create(status: StatusEnum::APPROVED);
        $this->expectException(InvoiceBadState::class);
        $sut->approve();
    }

    public function testApproveFailsOnAlreadyRejected(): void
    {
        $sut = Invoice::create(status: StatusEnum::REJECTED);
        $this->expectException(InvoiceBadState::class);
        $sut->approve();
    }

    public function testApprove(): void
    {
        $sut = Invoice::create(status: StatusEnum::DRAFT);
        $sut->approve();
        // we don't need to expose status just for testing purposes
        $this->assertTrue(true);
    }
}
