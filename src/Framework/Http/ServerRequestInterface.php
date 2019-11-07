<?php

namespace Framework\Http;
/**
 * @deprecated deprecated
 */
interface ServerRequestInterface
{
    /**
     * @return array
     */
    public function getQueryParams(): array;

    /**
     * @param array $query
     * @return mixed
     */
    public function withQueryParams(array $query);

    /**
     * @return mixed
     */
    public function getParsedBody();

    /**
     * @param $data
     * @return mixed
     */
    public function withParsedBody($data);
}