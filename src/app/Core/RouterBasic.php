<?php
namespace Picrab\Core;

class RouterBasic
{
    private $request;
    private $response;

    private $defaultGet;

    private $defaultMethod;


    public function __construct(Request $request, Response $response)
    {

        $this->defaultGet = [
            'type' => '1',
            'id' => '1',
            'page' => '1',
            'action' => '1',
        ];
        $this->defaultMethod = 'GET';
        $this->request = $request;
        $this->response = $response;
    }

    public function getData()
    {
        $routerMap = [];
        $routerMap['uri'] = @$this->request->getUri() ?: '/index.php';
        $routerMap['method'] = $this->request->getMethod() ?: 'GET';
        $routerMap['get']['type'] = @$this->request->getGet()['type'] ?:  '1';
        $routerMap['get']['id'] = @$this->request->getGet()['id'] ?: '1';
        $routerMap['get']['page'] = @$this->request->getGet()['page'] ?: '1';
        $routerMap['get']['action'] = @$this->request->getGet()['action'] ?: '1';

        return $routerMap;

    }


}