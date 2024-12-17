<?php
namespace Picrab\Core;

class RouterBasic
{
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getData(): array
    {
        $uri = $this->request->getUri() ?: '/index.php';
        $method = $this->request->getMethod() ?: 'GET';
        $get = $this->request->getGet();
        $data = [];
        $data['uri'] = $uri;
        $data['method'] = $method;
        $data['get']['id'] = $get['id'] ?? '1';
        return $data;
    }
}