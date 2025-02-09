<?php

declare(strict_types=1);

namespace Shared\Random;

interface RandomGeneratorInterface
{
    public function generate(int $length): mixed;
}
