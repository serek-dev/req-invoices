<?php

declare(strict_types=1);


namespace App\Modules\Invoices\Api;


use App\Modules\Invoices\Application\InvoiceFacade;

final class InvoiceController
{
    public function __invoke(ShowRequest $request, InvoiceFacade $facade)
    {
        return response()->json($facade->findInvoice($request->route('id')));
    }
}
