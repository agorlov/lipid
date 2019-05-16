<?php
namespace AG\WebApp;

interface Response
{
    public function print(): void;
    public function withBody(string $body): Response;
    public function withHeaders(array $headers): Response;
}
