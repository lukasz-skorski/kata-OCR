<?php

namespace App\Ocr\Domain\SignSchema;

interface SchemaRepositoryInterface
{
    public function getSchemasConfig(): array;
}