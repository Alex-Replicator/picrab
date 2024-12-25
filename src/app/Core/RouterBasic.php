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

    public function getData(): array {
        $uri = $this->request->getUri() ?: '/index.php';
        $method = $this->request->getMethod() ?: 'GET';
        $get = $this->request->getGet();
        $data = [];
        $data['uri'] = $uri;
        $data['method'] = $method;
        $data['get']['id'] = $get['id'] ?? '1';
        $data['get']['action'] = $get['action'] ?? 'view';
        $data['get']['pagetype'] = $get['pagetype'] ?? 'main'; // Добавляем pagetype
        $data['is_admin'] = ($data['get']['pagetype'] === 'admin'); // Определяем, админская ли это страница
        $data['is_ajax'] = isset($_GET['ajax']) && $_GET['ajax'] === 'true'; // Определяем, AJAX ли это запрос
        return $data;
    }
}
