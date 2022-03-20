<?php

namespace App\Ocr\Infrastructure;

use App\Ocr\Domain\AccountNumber\AccountNumber;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OcrReaderCommand extends Command
{
    protected static $defaultName = "app:ocr:read-numbers";

    public function __construct(
        string $name = null
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->addArgument('filePath', InputArgument::REQUIRED, "File path:")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}