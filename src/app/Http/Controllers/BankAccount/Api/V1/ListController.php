<?php

declare(strict_types=1);

namespace App\Http\Controllers\BankAccount\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Dto\BankAccount\ListDto;
use BankAccount\UseCases\List\ListUseCaseInterface;
use Illuminate\Http\JsonResponse;

class ListController extends Controller
{
    public function __construct(
        private readonly ListUseCaseInterface $interactor,
        private readonly ListDto $presenter,
    ) {
    }

    public function handle(): JsonResponse
    {
        $outputData = $this->interactor->handle();

        return response()->json($this->presenter->present($outputData));
    }
}
