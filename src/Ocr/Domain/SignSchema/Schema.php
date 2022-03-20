<?php

namespace App\Ocr\Domain\SignSchema;

use App\Ocr\Domain\SignSchema\Exceptions\InvalidCharLengthException;

class Schema
{
    private string $char;

    private array $template;

    private int $allowedShiftValue;

    public function __construct(
        string $char,
        array $template,
        int $allowedShiftValue = 1
    ) {
        $this->char = $char;
        $this->template = $template;
        $this->allowedShiftValue = $allowedShiftValue;
    }

    private function validate(string $char): void
    {
        if (strlen($char) === 1) {
            return;
        }

        throw new InvalidCharLengthException();
    }

    public function getChar(): string
    {
        return $this->char;
    }

    public function isExactTemplate(array $template): bool
    {
        return $template === $this->template;
    }

    final public function isSimilarTemplate(array $template): bool
    {
        $flatBaseTemplate = $this->array2DTo1D($this->template);
        $flatTestTemplate = $this->array2DTo1D($template);

        $shift = array_intersect_assoc($flatBaseTemplate, $flatTestTemplate);

        if ((count($shift) + $this->allowedShiftValue) >= count($flatBaseTemplate)) {
            return true;
        }

        return false;
    }

    private function array2DTo1D(array $input2dArray): array
    {
        $outputArray = [];
        foreach ($input2dArray as $subArray) {
            if (is_string($subArray)) {
                $subArray = str_split($subArray);
            }

            foreach ($subArray as $value) {
                $outputArray[] = $value;
            }
        }

        return $outputArray;
    }

    public function getTemplate(): array
    {
        return $this->template;
    }
}