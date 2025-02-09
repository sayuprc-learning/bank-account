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
        $response = $this->post(route(RouteMap::Create), [
            'amount' => 0,
        ])->assertStatus(200);

        $json = json_decode($response->getContent());

        $this->assertObjectHasProperty('balance', $json);
        $this->assertSame(0, $json->balance);
        // 口座番号はランダムなので存在のチェックのみを行う
        $this->assertObjectHasProperty('account_number', $json);
    }
}
