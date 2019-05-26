<?php
namespace Lipid\Response;

use Lipid\Response;

final class RespStd implements Response
{
    private $headers;
    private $body;
    public function __construct($body = '', $headers = [])
    {
        $this->body = $body;
        $this->headers = $headers;
    }

    public function withBody(string $body): Response
    {
        return new self($body, $this->headers);
    }

    public function withHeaders(array $headers): Response
    {
        return new self($this->body, $headers);
    }


    public function print(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }

        echo $this->body;
    }
}
