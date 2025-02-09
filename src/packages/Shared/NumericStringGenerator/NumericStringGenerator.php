<?php

declare(strict_types=1);

namespace Shared\NumericStringGenerator;

use Random\Randomizer;
use Shared\Random\RandomGeneratorInterface;

class NumericStringGenerator implements RandomGeneratorInterface
{
    private const string CHARACTERS_NUMERIC = '0123456789';

    public function __construct(private readonly Randomizer $randomizer)
    {
    }

    public function generate(int $length): string
    {
        return $this->randomizer->getBytesFromString(self::CHARACTERS_NUMERIC, $length);
    }
}
