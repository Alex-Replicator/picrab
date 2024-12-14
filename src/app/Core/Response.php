<?php
namespace Picrab\Core;

class Response
{
    private $statusCode = 200;
    private $headers = [];
    private $body;

    public function setStatusCode(int $code)
    {
        $this->statusCode = $code;
    }

    public function addHeader(string $header, string $value)
    {
        $this->headers[$header] = $value;
    }

    public function setBody(string $content)
    {
        $this->body = $content;
    }

    public function send()
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }
        return $this->body;
    }

    public function notFound($data = null){
        $this->setStatusCode(404);
        $this->setBody($data);
        return $this->send();

    }
}