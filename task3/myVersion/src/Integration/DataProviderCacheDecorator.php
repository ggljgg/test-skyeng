<?php

namespace Task3\Integration;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;

class DataProviderCacheDecorator implements DataProviderInterface
{
    const DEFAULT_EXPIRES_AT = '+1 day';

    /**
     * @var DataProviderInterface
     */
    protected $dataProvider;

    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var \DateTimeInterface|null
     */
    private $expiresAt;

    /**
     * @param DataProviderInterface  $dataProvider
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(
        DataProviderInterface $dataProvider,
        CacheItemPoolInterface $cache
    ) {
        $this->dataProvider = $dataProvider;
        $this->cache = $cache;
        $this->expiresAt = $this->setExpiresAt(self::DEFAULT_EXPIRES_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $request): array
    {
        $cacheKey = $this->getCacheKey($request);
        $cacheItem = $this->cache->getItem($cacheKey);
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $result = $this->dataProvider->get($request);

        $cacheItem
            ->set($result)
            ->expiresAt($this->getExpiresAt());

        return $result;
    }

    /**
     * @param string $expiresAt
     * @return \DateTimeInterface|null
     */
    public function setExpiresAt($expiresAt)
    {
        $modify = (new DateTime())->modify($expiresAt);
        if ($modify !== false) {
            $this->expiresAt = $modify;
        }

        $this->expiresAt = null;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param array  $request
     * @return string
     */
    private function getCacheKey(array $request): string
    {
        return hash('sha256', json_encode(serialize($request)));
    }
}
