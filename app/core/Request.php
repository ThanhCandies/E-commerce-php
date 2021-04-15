<?php

namespace App\core;

class Request
{

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '\/';
        $position = stripos($path, '?');
        if (!$position) {
            return $path;
        };
        return $path = substr($path, 0, $position);
    }

    public function getFile():array
    {

        return $_FILES['images'];
    }

    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function getBody(): array
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
        $pagination = ["start" => 0, "length" => 10];
        $newPag = array();

        $params = $this->getBody();
        foreach ($pagination as $key => $value) {
            $newPag[$key] = is_numeric($params[$key] ?? false) ? (int)$params[$key] : (int)$value;
        }
        return $newPag;
    }

    public function isGet(): bool
    {
        return $this->getMethod() === "GET";
    }

    public function isPost(): bool
    {
        return $this->getMethod() === "POST";
    }

}
