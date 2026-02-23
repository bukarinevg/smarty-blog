<?php
declare(strict_types=1);

namespace app\source\http;


/**
 * Class Route
 *
 */
class Route
{
    public function __construct(public string $controller, public string $method, public string|null $param = null)
    {
    }

    public function validate(): bool
    {
        if (!class_exists($this->controller)) {
            return false;
        }
        if (!method_exists($this->controller, $this->method)) {
            return false;
        }
        if ($this->isParam() && $this->param === null) {
            return false;
        }

        return true;
    }

    private function isParam(): bool
    {
        $reflector = new \ReflectionMethod($this->controller, $this->method);
        $params = $reflector->getParameters();
        return count($params) > 0;
    }

} 
