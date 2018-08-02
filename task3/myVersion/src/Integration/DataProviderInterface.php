<?php

namespace Task3\Integration;

interface DataProviderInterface
{
    /**
     * @param array $request
     * @return array
     */
    public function get(array $request): array;
}
