<?php
declare(strict_types=1);
namespace Charoday\MaxMessengerBot;

use Charoday\MaxMessengerBot\Exceptions\SecurityException;
use Charoday\MaxMessengerBot\Exceptions\SerializationException;
use Charoday\MaxMessengerBot\Models\UpdateList;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;

/**
 * Handles incoming webhook requests from the Max Bot API.
 * Verifies request signatures and dispatches updates to the update dispatcher.
 */
class WebhookHandler
{
    private $updateDispatcher;
    private $modelFactory;
    private $logger;
    private $secret;

    public function __construct(
        UpdateDispatcher $updateDispatcher,
        ModelFactory $modelFactory,
        LoggerInterface $logger = null,
        $secret = null
    ) {
        $this->updateDispatcher = $updateDispatcher;
        $this->modelFactory = $modelFactory;
        $this->logger = $logger ?: new NullLogger();
        $this->secret = $secret;
    }

    /**
     * Handles an incoming webhook request.
     *
     * @param ServerRequestInterface $request
     * @throws SecurityException
     * @throws SerializationException
     */
    public function handle(ServerRequestInterface $request)
    {
        $this->logger->debug('Received webhook request', [
            'method' => $request->getMethod(),
            'uri' => (string)$request->getUri(),
            'headers' => $request->getHeaders(),
        ]);

        if ($request->getMethod() !== 'POST') {
            throw new SecurityException('Only POST requests are allowed.');
        }

        $body = (string)$request->getBody();
        if (empty($body)) {
            throw new SerializationException('Empty request body.');
        }

        // Verify signature if secret is configured
        if ($this->secret !== null) {
            $signature = $request->getHeaderLine('X-Signature');
            if (empty($signature)) {
                throw new SecurityException('Missing X-Signature header.');
            }

            $expectedSignature = hash_hmac('sha256', $body, $this->secret);
            if (!hash_equals($expectedSignature, $signature)) {
                throw new SecurityException('Invalid X-Signature header.');
            }
        }

        $data = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new SerializationException('Invalid JSON in request body: ' . json_last_error_msg());
        }

        try {
            $updateList = $this->modelFactory->createUpdateList($data);
            foreach ($updateList->list as $update) {
                $this->updateDispatcher->dispatch($update);
            }
        } catch (Throwable $e) {
            $this->logger->error('Error processing webhook updates', [
                'exception' => $e,
                'request_body' => $body,
            ]);
            throw $e;
        }
    }
}
