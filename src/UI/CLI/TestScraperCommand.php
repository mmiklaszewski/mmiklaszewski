<?php

namespace App\UI\CLI;

use App\Domain\Service\FindMovieLink;
use App\Domain\ValueObject\MovieCategory;
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
    private FindMovieLink $findMovieDescriptions;

    public function __construct(
        FindMovieLink $findMovieDescriptions
    ) {
        parent::__construct();

        $this->findMovieDescriptions = $findMovieDescriptions;
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
        $title = $input->getArgument('title');

        $category = $input->getArgument('category');
        $link = $this->findMovieDescriptions->search($title, MovieCategory::fromString($category));

        dump($link);

        return Command::SUCCESS;
    }
}
