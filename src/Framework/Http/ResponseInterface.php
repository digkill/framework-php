<?php

namespace Framework\Http;

interface ResponseInterface
{
    /**
     * @return mixed
     */
    public function getBody();

    /**
     * @param $body
     * @return $this
     */
    public function withBody($body): self;

    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return mixed
     */
    public function getReasonPhrase();

    /**
     * @param $code
     * @param string $reasonPhrase
     * @return $this
     */
    public function withStatus($code, $reasonPhrase = ''): self;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @param $header
     * @return bool
     */
    public function hasHeader($header): bool;

    /**
     * @param $header
     * @return mixed
     */
    public function getHeader($header);

    /**
     * @param $header
     * @param $value
     * @return $this
     */
    public function withHeader($header, $value): self;
}