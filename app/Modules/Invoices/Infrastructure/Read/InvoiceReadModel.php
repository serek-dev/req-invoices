<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Read;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class InvoiceReadModel extends Model
{
    public $incrementing = false;

    protected $table = 'invoices';

    protected $keyType = 'string';

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyReadModel::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(ProductLineReadModel::class, 'invoice_id');
    }
}
