<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;
/**
 * @deprecated deprecated
 */
class ResponseSender
{
    public function send(ResponseInterface $response): void
    {
        header(sprintf(
            'HTTP/%s %d %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ));
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s %s', $name, $value), false);
            }
            echo $response->getBody()->getContents();
        }
    }
}