<?php

namespace App\UI\CLI;

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

#[AsCommand(
    name: 'mm:scraper',
    description: 'numbers',
    aliases: ['mm:s'],
    hidden: false
)]
final class TestScraperCommand extends Command
{
    private FindMovieDescriptions $descriptionsService;
    private SearchInNetworkClient $searchInNetworkClient;
    private FindMovieLink $findMovieLink;
    private FindMovieDetails $findMovieDetails;
    private FindMovieDetailsLink $findMovieDetailsLink;

    public function __construct(
        FindMovieDescriptions $descriptionsService,
        SearchInNetworkClient $searchInNetworkClient,
        FindMovieLink $findMovieLink,
        FindMovieDetails $findMovieDetails,
        FindMovieDetailsLink $findMovieDetailsLink
    ) {
        parent::__construct();
        $this->descriptionsService = $descriptionsService;
        $this->searchInNetworkClient = $searchInNetworkClient;
        $this->findMovieLink = $findMovieLink;
        $this->findMovieDetails = $findMovieDetails;
        $this->findMovieDetailsLink = $findMovieDetailsLink;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'title')
        ;
    }
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = $input->getArgument('title');
        $category = MovieCategory::series();

//        $wikiLink = $this->findMovieDetailsLink->search($title, $category);

        $wikiLink = Link::fromString('https://pl.wikipedia.org/wiki/Gra_o_tron_(serial_telewizyjny)');

        $details = $this->findMovieDetails->getDetails($wikiLink);
//        $filmwebLink = $this->findMovieLink->search($title, $category);
//        $descriptions = $this->descriptionsService->getDescriptions($filmwebLink);
//        dump($descriptions);
        dump($details);

        exit;

        $details = $this->findMovieDetails->getDetails(Link::fromString('https://pl.wikipedia.org/wiki/Titanic_(film_1997)'));
        dump($details);

        exit;

        $movieLink = $this->findMovieLink->search('breaking bad', MovieCategory::series());

        dump($movieLink);

        $descLink = Link::fromString(sprintf('%s/descs', $movieLink->toString()));

        $descriptions = $this->descriptionsService->getDescriptions($descLink);

        /** @var MovieDescription $description */
        foreach ($descriptions as $description) {
            dump($description->description);
        }

        dump($descriptions);

        return Command::SUCCESS;
    }
}
