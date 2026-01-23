<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot;

use Charoday\MaxMessengerBot\Exceptions\ClientApiException;
use Charoday\MaxMessengerBot\Exceptions\NetworkException;
use Charoday\MaxMessengerBot\Exceptions\SerializationException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;

/**
 * Handles the long polling loop for receiving updates from the Max Bot API.
 * This class is designed to run in a separate process or thread.
 */
class LongPollingHandler
{
    private $api;
    private $updateDispatcher;
    private $logger;

    public function __construct(
        Api $api,
        UpdateDispatcher $updateDispatcher,
        LoggerInterface $logger = null
    ) {
        $this->api = $api;
        $this->updateDispatcher = $updateDispatcher;
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * Starts the long polling loop.
     *
     * @param int $timeout The timeout in seconds for long polling (0-90).
     * @param int|null $marker The marker to start from (null for latest).
     * @throws ClientApiException
     * @throws NetworkException
     * @throws SerializationException
     * @codeCoverageIgnore
     */
    public function handle($timeout = 90, $marker = null)
    {
        $this->logger->info('Starting long polling loop...', [
            'timeout' => $timeout,
            'marker' => $marker,
        ]);

        while (true) {
            try {
                $updates = $this->api->getUpdates(100, $timeout, $marker);

                if (!empty($updates->list)) {
                    $lastUpdate = end($updates->list);
                    $marker = $lastUpdate->marker;
                    $this->logger->debug('Processing updates', [
                        'count' => count($updates->list),
                        'new_marker' => $marker,
                    ]);
                    foreach ($updates->list as $update) {
                        $this->updateDispatcher->dispatch($update);
                    }
                } else {
                    $this->logger->debug('No updates received.');
                }
            } catch (Throwable $e) {
                $this->logger->error('Error in long polling loop', [
                    'message' => $e->getMessage(),
                    'exception' => $e,
                ]);
                // Wait a bit before retrying to avoid hammering the API
                sleep(5);
            }
        }
    }
}
