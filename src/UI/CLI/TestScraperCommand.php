<?php

namespace App\UI\CLI;

use App\Domain\Service\FindWhereWatchMovie;
use App\Domain\ValueObject\Link;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'mm:scraper',
    description: 'numbers',
    aliases: ['mm:s'],
    hidden: false
)]
final class TestScraperCommand extends Command
{
    private FindWhereWatchMovie $findWhereWatchMovie;

    public function __construct(
        FindWhereWatchMovie $findWhereWatchMovie
    ) {
        parent::__construct();
        $this->findWhereWatchMovie = $findWhereWatchMovie;
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
        $link = Link::fromString('https://www.filmweb.pl/film/Zielona+mila-1999-862');

        $this->findWhereWatchMovie->findWhereWatch($link);

        exit;

        return Command::SUCCESS;
    }
}
