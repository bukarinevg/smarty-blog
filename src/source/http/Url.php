<?php
declare(strict_types=1);

namespace app\source\http;

class Url
{
    protected string $protocol {
        get {
            return $this->protocol;
        }
    }
    protected string $host {
        get {
            return $this->host;
        }
    }
    protected string $path {
        get {
            return $this->path;
        }
    }
    protected array|null $query {
        get {
            return $this->query;
        }
    }

    public function __construct(array $server)
    {
        $this->protocol = isset($server['HTTPS']) && $server['HTTPS'] === 'on' ? "https" : "http";
        $this->host = $server['HTTP_HOST'];
        $this->path = parse_url($server['REQUEST_URI'], PHP_URL_PATH);
        
        $queryString = parse_url($server['REQUEST_URI'], PHP_URL_QUERY);
        if (is_string($queryString) && $queryString !== '') {
            parse_str($queryString, $queryParams);
            $this->query = $queryParams;
        } else {
            $this->query = null;
        }
    }

    public function __toString(): string
    {
        $url = $this->protocol . '://' . $this->host . $this->path;
        if (!empty($this->query)) {
            $url .= '?' . http_build_query($this->query);
        }
        return $url;
    }
}

