<?php

namespace App\Ocr\Domain\SignSchema;

class SchemaProvider
{
    private const ALLOWED_SHIFT_VALUE = 1;

    private SchemaRepositoryInterface $schemaRepository;

    /**
     * @var Schema[]
     */
    private array $schemas;

    public function __construct(
        SchemaRepositoryInterface $schemaRepository
    ) {
        $this->schemaRepository = $schemaRepository;
        $this->schemas = [];
        $this->prepareValidSchema();
    }

    private function prepareValidSchema(): void
    {
        $rawSchemaData = $this->schemaRepository->getSchemasConfig();
        foreach ($rawSchemaData as $char => $rawSchema) {
            $this->schemas[] = new Schema(
                (string)$char,
                $rawSchema,
                self::ALLOWED_SHIFT_VALUE
            );
        }
    }

    public function findExactSchemaByTemplate(array $template): ?Schema
    {
        foreach ($this->schemas as $schema) {
            if ($schema->isExactTemplate($template)) {
                return $schema;
            }
        }

        return null;
    }

    public function findSimilarSchemasByTemplate(array $template): array
    {
        $similarSchemas = [];

        foreach ($this->schemas as $schema) {
            if ($schema->isSimilarTemplate($template)) {
                $similarSchemas[] = $schema;
            }
        }

        return $similarSchemas;
    }
}