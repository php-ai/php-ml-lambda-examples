<?php

declare(strict_types=1);

namespace PhpmlLambda\Command;

use Phpml\Classification\SVC;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\Dataset\Demo\IrisDataset;
use Phpml\Metric\Accuracy;
use Phpml\ModelManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TrainIrisCommand extends Command
{
    protected function configure()
    {
        $this->setName('train:iris')
            ->setDescription('Train Iris model')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataset = new StratifiedRandomSplit(new IrisDataset(), 0.1);

        $classifier = new SVC();
        $classifier->train($dataset->getTrainSamples(), $dataset->getTrainLabels());

        $predicted = $classifier->predict($dataset->getTestSamples());

        $output->writeln(sprintf('Accuracy: %s', Accuracy::score($dataset->getTestLabels(), $predicted)));

        $manager = new ModelManager();
        $manager->saveToFile($classifier, __DIR__.'/../../model/iris.phpml');
    }
}
