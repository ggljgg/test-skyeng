<?php

namespace Task3\Integration;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareTrait;

class DataProviderLoggerDecorator implements DataProviderInterface
{
    use LoggerAwareTrait;

    /**
     * @var DataProviderInterface
     */
    protected $dataProvider;

    /**
     * @param DataProviderInterface  $dataProvider
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(DataProviderInterface $dataProvider, LoggerInterface $logger)
    {
        $this->dataProvider = $dataProvider;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $request): array
    {
        try {
            return $this->dataProvider->get($request);
        } catch (Exception $e) {
            $this->logger->critical('Critical '. $e->getMessage());
            return [];
        }
    }
}
