<?php

declare(strict_types=1);

namespace Tests\Feature\BankAccount\Api\V1;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Shared\Route\Api\V1\RouteMap;
use Tests\TestCase;

class CreateAccountTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function 口座の作成ができる(): void
    {
        $this->post(route(RouteMap::Create), [
            'account_number' => '00000000',
            'amount' => 0,
        ])->assertStatus(200)
            ->assertJson([]);
    }
}
