<?php

declare(strict_types=1);

namespace Tests\Feature\BankAccount\Api\V1;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ListTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function 口座の一覧表示ができる(): void
    {
        DB::table('bank_accounts')->insert([
            'account_number' => '00000000',
            'balance' => 0,
        ]);

        $this->get('/api/v1/list')
            ->assertStatus(200)
            ->assertJson([
                [
                    'account_number' => '00000000',
                    'balance' => 0,
                ],
            ]);
    }
}
