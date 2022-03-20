<?php

namespace App\Ocr\Infrastructure;

use App\Ocr\Domain\SignSchema\SchemaRepositoryInterface;

class BasicSchemaRepository implements SchemaRepositoryInterface
{
    public function getSchemasConfig(): array
    {
        return [
            0 => [
                " _ ",
                "| |",
                "|_|",
            ],
            1 => [
                "  ",
                "  |",
                "  |",
            ],
            2 => [
                " _ ",
                " _|",
                "|_ ",
            ],
            3 => [
                " _ ",
                " _|",
                " _|",
            ],
            4 => [
                "   ",
                "|_|",
                "  |",
            ],
            5 => [
                " _ ",
                "|_ ",
                " _|",
            ],
            6 => [
                " _ ",
                "|_",
                "|_|",
            ],
            7 => [
                " _ ",
                "  |",
                "  |",
            ],
            8 => [
                " _ ",
                "|_|",
                "|_|",
            ],
            9 => [
                " _ ",
                "|_|",
                " _|",
            ],
        ];
    }
}