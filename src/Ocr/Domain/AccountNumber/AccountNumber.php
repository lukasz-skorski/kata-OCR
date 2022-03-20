<?php

namespace App\Ocr\Domain\AccountNumber;

use App\Ocr\Domain\SignSchema\SchemaProvider;

class AccountNumber
{
    /**
     * @var AccountNumberSchema[]
     */
    private array $accountNumberSchemas = [];

    public function __construct(
        array $accountNumbersTemplate,
        SchemaProvider $schemaProvider
    ) {
        foreach ($accountNumbersTemplate as $accountNumber) {
            $this->accountNumberSchemas[] = new AccountNumberSchema(
                $accountNumber,
                $schemaProvider
            );
        }
    }

    public function isValidAccountNumber(): bool
    {
        foreach ($this->accountNumberSchemas as $accountNumberSchema) {
            if (! $accountNumberSchema->isNumberValid()) {
                return false;
            }
        }

        return $this->isValidCheckSum();
    }

    private function isValidCheckSum(): bool
    {
        $testSchemasArray = array_reverse($this->accountNumberSchemas);
        reset($testSchemasArray);
        $checkSum = 0;
        foreach ($testSchemasArray as $key => $schema) {
            $checkSum += ($key + 1) * $schema->getSchemaValue();
        }
        if ($checkSum === 0) {
//            Dla numeru konta z samymi zerami??
            return false;
        }

        return ($checkSum % 11) === 0;
    }

    public function getAccountNumber(): ?string
    {
        $accountNumber = "";
        foreach ($this->accountNumberSchemas as $accountNumberSchema) {
            if (! $accountNumberSchema->isNumberValid()) {
                return null;
            }
            $accountNumber .= $accountNumberSchema->getSchemaValue();
        }

        return $accountNumber;
    }

    public function getPossibleNumbers(): array
    {
        if ($this->isValidCheckSum()) {
            return [];
        }

        $availableNumbers = [""];

        $this->recursiveNumbersGenerator($this->accountNumberSchemas, $availableNumbers);

        return $availableNumbers;
    }

    /**
     * @param AccountNumberSchema[] $numbersSchemas
     * @param string[]              $accountNumbers
     */
    private function recursiveNumbersGenerator(array $numbersSchemas, array &$accountNumbers): array
    {
        if (count($numbersSchemas) === 0) {
            return $accountNumbers;
        }

        $numberSchema = array_shift($numbersSchemas);
        if ($numberSchema->isNumberValid()) {
            foreach ($accountNumbers as &$accountNumber) {
                $accountNumber += (string)$numberSchema->getSchemaValue();
            }

            return $this->recursiveNumbersGenerator($numbersSchemas, $accountNumbers);
        }

        $newNumbers = [];
        foreach ($accountNumbers as $key => $accountNumber) {
            unset($accountNumbers[$key]);

            foreach ($numberSchema->getSimilarSchemas() as $similarSchema) {
                $accountNumbers[] = $accountNumber.$similarSchema->getChar();
            }
        }
        $accountNumbers = array_merge($accountNumbers, $newNumbers);

        return $this->recursiveNumbersGenerator($numbersSchemas, $accountNumbers);
    }
}