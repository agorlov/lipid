<?php
namespace Lipid\Response;

use Lipid\Response;
use Exception;

/**
 * Response json (Decorator RespStd)
 *
 * Example (in action):
 * ```php
 *   return new RespJson(['result' => 'ok', 'message' => $res], $resp);
 * ```
 * @author agorlov
 * @author Klepatskiy
 */
final class RespJson implements Response
{
    private $json;
    private $orig;

    /**
     * RespJson constructor.
     *
     * @param mixed $json any data to return as json
     * @param Response|null $orig
     */
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
        $jsonString = json_encode($this->json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($jsonString === false) {
            throw new Exception('Failed to json encode: ' . var_export($this->json));
        }
        $this->withBody($jsonString)
            ->withHeaders(['Content-type' => 'application/json'])
            ->print();
    }
}
