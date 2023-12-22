<?php

namespace App\Application\Command\GenerateReview;

use App\Domain\Client\OpenAIClient;
use App\Domain\Collection\AI\Messages;
use App\Domain\Event\Movie\AIReviewWasGenerated;
use App\Domain\ReadModel\MovieReadModel;
use App\Domain\ValueObject\AI\Message;
use App\Domain\ValueObject\AI\Model;
use App\Domain\ValueObject\AI\OpenAIConfiguration;
use App\Domain\ValueObject\AI\ResponseFormat;
use App\Domain\ValueObject\AI\Role;
use App\Domain\ValueObject\AIMovieReview;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsMessageHandler]
final readonly class GenerateReviewHandler
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private TranslatorInterface $translator,
        private OpenAIClient $openAIClient,
        private MovieReadModel $movieReadModel
    ) {
    }

    public function __invoke(GenerateReviewCommand $command): void
    {
        $entity = $this->movieReadModel->find($command->movie);

        $messages = Messages::create();
        $messages->append(
            new Message(
                Role::system(),
                $this->translator->trans('generateReview.system', [
                    '%movie_descriptions%' => str_replace(
                        ['„', '”'],
                        ['', ''],
                        implode(';', array_slice($entity->getDescriptions() ?? [], 0, 3))
                    ),
                    '%movie_details%' => json_encode($entity->getDetails() ?? []),
                    '%user_preferences%' => $entity->getPreferences(),
                ], 'prompt')
            )
        );
        $messages->append(
            new Message(
                Role::user(),
                $this->translator->trans('generateReview.prompt', [
                ], 'prompt')
            )
        );

        $configuration = new OpenAIConfiguration(
            Model::gpt3_5_turbo(),
            ResponseFormat::json(),
            0.7,
        );

        $result = $this->openAIClient->request($configuration, $messages);

        $aiMovieReview = AIMovieReview::fromString($result);

        $this->dispatcher->dispatch(
            new AIReviewWasGenerated(
                $command->movie,
                $aiMovieReview
            )
        );
    }
}
