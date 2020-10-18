<?php

declare(strict_types=1);

namespace Track\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Track\Model\Mean;
use Track\Service\Csv\Builder\MeansBuilder;
use Track\Service\Csv\CsvReaderInterface;
use Track\Service\Csv\CsvWriterInterface;
use Track\Service\Csv\Parser\StudentsParser;
use Track\UseCase\TopVsBottomUseCase;

class TopVsBottomCommand extends Command
{
    public const NAME = 'top-vs-bottom';

    private TopVsBottomUseCase $useCase;
    private StudentsParser $studentsParser;
    private MeansBuilder $meansBuilder;
    private CsvReaderInterface $csvReader;
    private CsvWriterInterface $csvWriter;

    public function __construct(
        TopVsBottomUseCase $useCase,
        StudentsParser $studentsParser,
        MeansBuilder $meansBuilder,
        CsvReaderInterface $csvReader,
        CsvWriterInterface $csvWriter
    ) {
        parent::__construct(self::NAME);

        $this->useCase = $useCase;
        $this->studentsParser = $studentsParser;
        $this->meansBuilder = $meansBuilder;
        $this->csvReader = $csvReader;
        $this->csvWriter = $csvWriter;
    }

    protected function configure()
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $file = $input->getArgument('file');

        if (!is_string($file)) {
            $io->error('The file argument is invalid.');

            return 1;
        }

        $csv = $this->csvReader->read($file);
        $students = $this->studentsParser->parse($csv);
        $means = $this->useCase->calculateMeans($students);
        $tops = $this->useCase->getTops($means);
        $bottoms = $this->useCase->getBottoms($means);

        $topsAndBottoms = array_merge(
            $this->sortByStudentId($bottoms),
            $this->sortByStudentId($tops),
        );

        $csv = $this->meansBuilder->build($topsAndBottoms);

        $output->write(
            $this->csvWriter->write($csv),
        );

        return 0;
    }

    private function sortByStudentId(array $means): array
    {
        usort(
            $means,
            fn (Mean $a, Mean $b): int => strcmp(
                $a->getStudent()->getId(),
                $b->getStudent()->getId(),
            ),
        );

        return $means;
    }
}
