<?php

namespace App\Tests\Ocr;

use App\Ocr\Domain\SignSchema\Schema;
use PHPUnit\Framework\TestCase;

class AbstractSchemaTest extends TestCase
{
    public function test_compare_exact_the_same_schema_should_be_success(): void
    {
        $schema = $this->createEightSchema();

        $isExact = $schema->isExactTemplate([
            " _ ",
            "|_|",
            "|_|",
        ]);

        self::assertEquals(true, $isExact);
    }

    public function test_compare_exact_with_different_schema_should_be_failure(): void
    {
        $schema = $this->createEightSchema();

        $isExact = $schema->isExactTemplate([
            " _ ",
            "| |",
            "|_|",
        ]);

        self::assertEquals(false, $isExact);
    }

    public function test_compare_similar_with_one_change_return_success(): void
    {
        $schema = $this->createEightSchema();

        $isExact = $schema->isSimilarTemplate([
            "   ",
            "|_|",
            "|_|",
        ]);

        self::assertEquals(true, $isExact);
    }

    public function test_compare_similar_with_two_changes_return_failure(): void
    {
        $schema = $this->createEightSchema();

        $isExact = $schema->isSimilarTemplate([
            "   ",
            "| |",
            "|_|",
        ]);

        self::assertEquals(false, $isExact);
    }

    private function createEightSchema(): Schema
    {
        return new Schema(
            "8",
            [
                " _ ",
                "|_|",
                "|_|",
            ],
            1
        );
    }
}
