<?php
namespace Picrab\Core;

class Request
{
    private mixed $method;
    private string|int|array|null|false $uri;
    private array $get;
    private array $post;
    private array|false $headers;

    private $requestConfig ;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->get = $_GET;
        $this->post = $_POST;
        $this->headers = getallheaders();
    }

    public function getrequestConfig(): array
    {
        $this->requestConfig = [
            'method' => $this->method,
            'uri' => $this->uri,
            'get' => $this->get,
            'post' => $this->post,
            'headers' => $this->headers
        ];
        return $this->requestConfig;
    }

    public function setReuqestConfig($requestConfig)
    {
        $this->requestConfig = $requestConfig;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getGet():array
    {
        return $this->get;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}