<?php

declare(strict_types=1);

namespace BankAccount\UseCases\List;

/**
 * 口座一覧のユースケースを抽象化したもの
 */
interface ListUseCaseInterface
{
    public function handle(): ListResponse;
}
