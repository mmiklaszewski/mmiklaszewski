<?php

namespace App\UI\CLI;

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
