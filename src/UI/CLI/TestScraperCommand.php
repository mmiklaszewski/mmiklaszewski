<?php

namespace App\UI\CLI;

use App\Application\Command\CollectDataAboutMovie\CollectDataAboutMovieCommand;
use App\Application\Command\CommandBus;
use App\Domain\Client\SearchInNetworkClient;
use App\Domain\Service\FindMovieDescriptions;
use App\Domain\Service\FindMovieDetails;
use App\Domain\Service\FindMovieDetailsLink;
use App\Domain\Service\FindMovieLink;
use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieCategory;
use App\Domain\ValueObject\MovieDescription;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Uuid;

#[AsCommand(
    name: 'mm:scraper',
    description: 'numbers',
    aliases: ['mm:s'],
    hidden: false
)]
final class TestScraperCommand extends Command
{

    public function __construct(

    ) {
        parent::__construct();

    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'title')
            ->addArgument('category', InputArgument::REQUIRED, 'category')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {

        return Command::SUCCESS;
    }
}
