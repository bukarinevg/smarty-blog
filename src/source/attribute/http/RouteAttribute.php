<?php
declare(strict_types=1);

namespace app\source\attribute\http;

use app\source\enums\ParamTypeEnum;
use app\source\exceptions\BadRequestException;
use Attribute;

/**
 * Class Route Attribute
 *
 * This class is an attribute that defines a route.
 */
#[Attribute]
class RouteAttribute
{
    public function __construct(private readonly string $method, private readonly ?string $param = null)
    {
    }

    public function validate(): bool
    {
        if ($this->method == $_SERVER['REQUEST_METHOD']) {

            if ($this->param == null) {
                return true;
            }

            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $lastPathValue = basename($path);

            if (is_numeric($lastPathValue) && $this->param == ParamTypeEnum::INT->value) {
                return true;
            }

            if ($this->param == ParamTypeEnum::STRING->value) {
                return true;
            }

            throw new BadRequestException('The param is not valid');
        }
        return false;
    }

}
