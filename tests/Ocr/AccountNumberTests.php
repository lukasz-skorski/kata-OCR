<?php

namespace App\Tests\Ocr;

use App\Ocr\Domain\AccountNumber\AccountNumber;
use App\Ocr\Domain\SignSchema\SchemaProvider;
use App\Ocr\Infrastructure\BasicSchemaRepository;
use App\Tests\Ocr\Util\CharGetterTrait;
use PHPUnit\Framework\TestCase;
use Throwable;

class AccountNumberTests extends TestCase
{
    use CharGetterTrait;

    /**
     * @dataProvider accountNumberWithTheSameSignDataProvider
     */
    public function test_number_with_the_same_sign(
        $expectedAccountNumber,
        array $template
    ): void {
        $accountNumber = new AccountNumber(
            $template,
            (new SchemaProvider(new BasicSchemaRepository()))
        );
        $givenAccountNumber = $accountNumber->getAccountNumber();
//        $isValid = $accountNumber->isValidAccountNumber();

        self::assertEquals($expectedAccountNumber, $givenAccountNumber);
//        self::assertEquals(false, $isValid);
    }

    public function test_account_number_with_different_chars(): void
    {
        $templateArray = [];
        $expectedAccountNumber = "";
        foreach (range(1, 9) as $number) {
            $templateArray[] = $this->getCharByKey($number);
            $expectedAccountNumber .= $number;
        }

        $accountNumber = new AccountNumber(
            $templateArray,
            (new SchemaProvider(new BasicSchemaRepository()))
        );
        $givenAccountNumber = $accountNumber->getAccountNumber();

        self::assertEquals($expectedAccountNumber, $givenAccountNumber);
    }

    public function test_account_number_with_valid_checksum(): void
    {
        $validAccountNumberInArray = ["0", "0", "0", "0", "0", "0", "0", "5", "1"];

        $templateArray = [];
        $expectedAccountNumber = "";
        foreach ($validAccountNumberInArray as $number) {
            $templateArray[] = $this->getCharByKey($number);
            $expectedAccountNumber .= $number;
        }

        $accountNumber = new AccountNumber(
            $templateArray,
            (new SchemaProvider(new BasicSchemaRepository()))
        );
        $givenAccountNumber = $accountNumber->getAccountNumber();
        $isValid = $accountNumber->isValidAccountNumber();

        self::assertEquals($expectedAccountNumber, $givenAccountNumber);
        self::assertEquals(true, $isValid);
    }

    public function accountNumberWithTheSameSignDataProvider(): array
    {
        $returnArray = [];

        foreach (range(0, 9) as $number) {
            $accountNumber = "";
            $templateArray = [];
            foreach (range(0, 8) as $nextStep) {
                $accountNumber .= $number;
                $templateArray[] = $this->getCharByKey((string)$number);
            }
            $returnArray[] = [
                $accountNumber,
                $templateArray,
            ];
        }

        return $returnArray;
    }
}