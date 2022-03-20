<?php

namespace App\Ocr\Domain\AccountNumber;

use App\Ocr\Domain\SignSchema\Schema;
use App\Ocr\Domain\SignSchema\SchemaProvider;
use Exception;

class AccountNumberSchema
{
    private ?Schema $schema = null;

    /**
     * @var Schema[]
     */
    private array $similarSchemas = [];

    public function __construct(array $template, SchemaProvider $schemaProvider)
    {
        $this->initialize($template, $schemaProvider);
    }

    private function initialize(array $template, SchemaProvider $schemaProvider): void
    {
        $this->schema = $schemaProvider->findExactSchemaByTemplate($template);
        if ($this->schema != null) {
            //TODO dorobić walidacje czy schema jest numerem
            return;
        }
        $this->similarSchemas = $schemaProvider->findSimilarSchemasByTemplate($template);
    }

    public function isNumberValid(): bool
    {
        return is_object($this->schema);
    }

    public function getSchemaValue(): int
    {
        if ($this->schema === null) {
            throw new Exception("Missing value exception");
        }

        return (int)$this->schema->getChar();
    }

    /**
     * @return Schema[]
     */
    public function getSimilarSchemas(): array
    {
        return $this->similarSchemas;
    }
}
