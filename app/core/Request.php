<?php

namespace App\core;

class Request
{

    public function getPath()
    {
//        dd($_SERVER)
        $path = $_SERVER['REQUEST_URI'] ?? '\/';
        $position = stripos($path, '?');
        if (!$position) {
            return $path;
        };
        return $path = substr($path, 0, $position);
    }

    public function getMethod()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function getBody()
    {
        $body = [];
        if (isset($_SERVER["CONTENT_TYPE"])
            && $_SERVER["CONTENT_TYPE"] === 'application/json; charset=UTF-8'
            && $this->getMethod() === 'POST') {
            $_POST = json_decode(file_get_contents('php://input'));
        }

        // need handle application/json latter
        // dump($_POST);
        if ($this->getMethod() === 'GET') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->getMethod() === 'POST') {
            foreach ($_POST as $key => $value) {
                // $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }

    public function getPagination(): array
    {
        $paginations = ["page" => 1, "limit" => 10];
        $newPag = array();

        $params = $this->getBody();
        foreach ($paginations as $key => $value) {
            $newPag[$key] = is_numeric($params[$key]??false) ?(int) $params[$key] :(int) $value;
        }
        return $newPag;
    }

    public function isGet()
    {
        return $this->getMethod() === "GET";
    }

    public function isPost()
    {
        return $this->getMethod() === "POST";
    }

}
