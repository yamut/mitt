<?php

namespace Tests\Feature;

use App\Enums\HttpStatus;
use App\Rules\EnumRule;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use TypeError;

class ValidationTest extends TestCase
{
    public function testEnumRuleExplodes(): void
    {
        $this->expectException(TypeError::class);
        $validator = Validator::make(['foo' => 'bar'], ['foo' => [new EnumRule(HttpStatus::class)]]);
        $validator->passes();
    }

    /**
     * @return array<string, array<int, bool|int>>
     */
    public static function providesHttpStatusValue(): array
    {
        return [
            'fails' => [1, false],
            'passes' => [300, true],
        ];
    }

    /**
     * @param int $code
     * @param bool $passes
     * @return void
     * @dataProvider providesHttpStatusValue
     */
    public function testEnumRule(int $code, bool $passes): void
    {
        $validator = Validator::make(['foo' => $code], ['foo' => [new EnumRule(HttpStatus::class)]]);
        $this->assertEquals($passes, $validator->passes());
    }
}
