<?php

namespace App\core;

use JetBrains\PhpStorm\Pure;

class Request
{

    #[Pure] public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '\/';
        $position = stripos($path, '?');
        if (!$position) {
            return $path;
        };
        return $path = substr($path, 0, $position);
    }

    public function getFile(): array
    {

        return $_FILES['images'];
    }

    #[Pure] public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
    public static function filterObject($object): array
    {
        $body=[];
        foreach ($object as $key => $value) {
            if (is_array($value)) {
                $body[$key] = self::filterObject($value);
            } else {
                $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }

    public function getBody(): array
    {
        $body = [];
        if (isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] === 'application/json; charset=UTF-8') {
            if ($this->getMethod() === 'GET') {
                foreach ($_GET as $key => $value) {
                    if (is_array($value)) {
                        $body[$key]=self::filterObject($value);
                    } else {
                        $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
            if ($this->getMethod() === 'POST') {
                $_POST = json_decode(file_get_contents('php://input'));
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $body[$key] = filter_var_array($value);
                    } else {
                        $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
            return $body;
        }
        // dump($_POST);
        if ($this->getMethod() === 'GET') {
            foreach ($_GET as $key => $value) {
                if (is_array($value)) {
                    $body[$key]=self::filterObject($value);
                } else {
                    $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        if ($this->getMethod() === 'POST') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
//                $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }

    public function getPagination(): array
    {
        $pagination = [
            "length" => 10,
            "page" => 1,
        ];

        $params = $this->getBody();
        foreach ($pagination as $key => $value) {
            $params[$key] = is_numeric($params[$key] ?? false) ? (int)$params[$key] : $value;
        }
        return $params;
    }

    #[Pure] public function isGet(): bool
    {
        return $this->getMethod() === "GET";
    }

    #[Pure] public function isPost(): bool
    {
        return $this->getMethod() === "POST";
    }

}
