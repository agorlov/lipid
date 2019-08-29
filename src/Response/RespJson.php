<?php
namespace Lipid\Response;

use Lipid\Response;

final class RespJson implements Response
{
    private $json;
    private $orig;

    public function __construct($json, Response $orig = null)
    {
        $this->json = $json;
        $this->orig = $orig ?? new RespStd();
    }

    public function withBody(string $body): Response
    {
        return $this->orig->withBody($body);
    }

    public function withHeaders(array $headers): Response
    {
        return $this->orig->withHeaders($headers);
    }

    public function print(): void
    {
        $this->withBody(json_encode($this->json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
            ->withHeaders(['Content-type' => 'json'])
            ->print();
    }
}
