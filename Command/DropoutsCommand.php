<?php

declare(strict_types=1);

namespace Track\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Track\Model\Student;
use Track\Service\Csv\Builder\StudentsBuilder;
use Track\Service\Csv\CsvReaderInterface;
use Track\Service\Csv\CsvWriterInterface;
use Track\Service\Csv\Parser\StudentsParser;
use Track\UseCase\DropoutsUseCase;

class DropoutsCommand extends Command
{
    public const NAME = 'dropouts';

    private DropoutsUseCase $useCase;
    private StudentsParser $studentsParser;
    private StudentsBuilder $studentsBuilder;
    private CsvReaderInterface $csvReader;
    private CsvWriterInterface $csvWriter;

    public function __construct(
        DropoutsUseCase $useCase,
        StudentsParser $studentsParser,
        StudentsBuilder $studentsBuilder,
        CsvReaderInterface $csvReader,
        CsvWriterInterface $csvWriter
    ) {
        parent::__construct(self::NAME);

        $this->useCase = $useCase;
        $this->studentsParser = $studentsParser;
        $this->studentsBuilder = $studentsBuilder;
        $this->csvReader = $csvReader;
        $this->csvWriter = $csvWriter;
    }

    protected function configure()
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $file = $input->getArgument('file');

        if (!is_string($file)) {
            $io->error('The file argument is invalid.');

            return 1;
        }

        $csv = $this->csvReader->read($file);
        $students = $this->studentsParser->parse($csv);
        $dropouts = $this->useCase->getDropouts($students);

        usort(
            $dropouts,
            fn (Student $a, Student $b): int => strcmp($a->getId(), $b->getId()),
        );

        $csv = $this->studentsBuilder->build($dropouts);

        $output->write(
            $this->csvWriter->write($csv),
        );

        return 0;
    }
}
