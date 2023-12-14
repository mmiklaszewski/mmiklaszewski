<?php

namespace App\UI\CLI;

use App\Application\Query\GetMovieDescriptions\GetMovieDescriptionsQuery;
use App\Application\Query\QueryBus;
use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieDescription;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
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
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        parent::__construct();
        $this->queryBus = $queryBus;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $link = 'https://www.filmweb.pl/serial/Breaking+Bad-2008-430668';
        $descLink = sprintf('%s/descs', $link);

        $descriptions = $this->queryBus->handle(new GetMovieDescriptionsQuery(Link::fromString($descLink)));

        /** @var MovieDescription $description */
        foreach ($descriptions as $description) {
            dump($description->description);
        }

        dump($descriptions);

        return Command::SUCCESS;
    }
}
