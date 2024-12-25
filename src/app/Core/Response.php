<?php
namespace Picrab\Core;

class Response
{
    private int $statusCode = 200;
    private array $headers = [];
    private string $body = '';

    public function setStatusCode(int $code): void {
        $this->statusCode = $code;
    }

    public function addHeader(string $header, string $value): void {
        $this->headers[$header] = $value;
    }

    public function setBody(string $content): void {
        $this->body = $content;
    }

    public function send(): void {
        http_response_code($this->statusCode);
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }
        echo $this->body;
    }

    public function notFound(string $data = ''): void {
        $this->setStatusCode(404);
        $this->setBody($data);
        $this->send();
    }

    public function json(array $data, int $statusCode = 200): void {
        $this->setStatusCode($statusCode);
        $this->addHeader('Content-Type', 'application/json');
        $this->setBody(json_encode($data));
        $this->send();
    }
}
