<?php

namespace App\UI\CLI;

use App\Application\Command\CommandBus;
use App\Application\Command\CreateCode\CreateCodeCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'code:create',
    description: 'command for create new code',
    aliases: ['co:c'],
    hidden: false
)]
final class CreateNewCodeCommand extends Command
{
    public function __construct(
        private CommandBus $commandBus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('code', InputArgument::REQUIRED, 'code')
            ->addArgument('limit', InputArgument::REQUIRED, 'limit');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $code = $input->getArgument('code');
        $limit = $input->getArgument('limit');

        dump($code);
        dump($limit);

        $this->commandBus->handle(
            new CreateCodeCommand(
                $code,
                $limit
            )
        );

        return Command::SUCCESS;
    }
}
