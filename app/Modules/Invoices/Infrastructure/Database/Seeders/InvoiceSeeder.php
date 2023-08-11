<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Seeders;

use App\Domain\Enums\StatusEnum;
use Faker\Factory;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class InvoiceSeeder extends Seeder
{
    public const FIRST_DRAFT_INVOICE_ID = '1594d999-28ad-4699-9b28-4236ea48aa1f';
    public const SECOND_DRAFT_INVOICE_ID = '20de6782-ce3e-4094-b7e7-5ec350dc4182';

    public function __construct(
        private ConnectionInterface $db
    ) {
    }

    public function run(): void
    {
        $companies = $this->db->table('companies')->get();
        $products = $this->db->table('products')->get();

        $faker = Factory::create();

        $invoices = [];

        for ($i = 0; $i < 10; $i++) {
            $uuid = Uuid::uuid4()->toString();
            $status = StatusEnum::cases()[array_rand(StatusEnum::cases())];

            switch ($i) {
                case 0:
                    $uuid = self::FIRST_DRAFT_INVOICE_ID;
                    $status = StatusEnum::DRAFT;
                    break;
                case 1:
                    $uuid = self::SECOND_DRAFT_INVOICE_ID;
                    $status = StatusEnum::DRAFT;
                    break;
            }

            $invoices[] = [
                'id' => $uuid,
                'number' => $faker->uuid(),
                'date' => $faker->date(),
                'due_date' => $faker->date(),
                'company_id' => $companies->random()->id,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $this->db->table('invoices')->insert($invoices);
        $this->addInvoiceProductLines($products, $invoices);
    }

    private function addInvoiceProductLines(Collection $products, array $invoices): void
    {

        $lines = [];

        foreach ($invoices ?? [] as $invoice) {
            $randomNumberOfProducts = rand(1, 5);
            $freshProducts = clone $products;

            for ($i = 0; $i < $randomNumberOfProducts; $i++) {
                $lines[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'invoice_id' => $invoice['id'],
                    'product_id' => $freshProducts->pop()->id,
                    'quantity' => rand(1, 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $this->db->table('invoice_product_lines')->insert($lines);
    }
}
