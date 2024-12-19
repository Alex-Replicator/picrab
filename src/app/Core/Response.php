<?php
namespace Picrab\Core;

class Response
{
    private int $statusCode =200;
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

    public function send(): string {
        http_response_code($this->statusCode);
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }
        return $this->body;
    }

    public function notFound(string $data = ''): string {
        $this->setStatusCode(404);
        $this->setBody($data);
        return $this->send();
    }
}
