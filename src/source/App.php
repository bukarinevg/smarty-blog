<?php
declare(strict_types=1);

namespace app\source;

use app\source\attribute\http\RouteValidationResource;
use app\source\exceptions\BadRequestException;
use app\source\exceptions\NotFoundException;
use app\source\http\RequestHandler;
use app\source\http\UrlRouting;
use BadMethodCallException;
use PDOException;

readonly class App
{
    use SingletonTrait;

    private RequestHandler $request;

    public function __construct(#[\SensitiveParameter] private array $config)
    {
    }

    public function run(): void
    {
        try {
            $this->setRequest(new RequestHandler());
            $route = new UrlRouting()->getRouteDetails();
            $routeAction = $this->getRouteAction($route->controller, $route->method, $route->param);
            $result = $routeAction($route->param);

            if (is_string($result)) {
                echo $result;
                return;
            }

            header('Content-Type: application/json');
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } catch (NotFoundException $th) {
            http_response_code(404);
            echo '404 Not Found: ' . $th->getMessage();
        } catch (BadMethodCallException $th) {
            http_response_code(405);
            echo '405 Method Not Allowed: ' . $th->getMessage();
        } catch (BadRequestException $th) {
            http_response_code(400);
            echo '400 Bad Request: ' . $th->getMessage();
        } catch (PDOException $th) {
            http_response_code(500);
            echo '500 Internal Server Error: ' . $th->getMessage();
        } catch (\Throwable $th) {
            http_response_code(500);
            echo '500 Internal Server Error: ' . $th->getMessage();
        }
    }

    private function getRouteAction(string $controller, string $method, string|null $param): callable
    {
        $controllerInstance = new $controller($this);
        RouteValidationResource::validateRoute(
            class: $controllerInstance::class,
            method: $method,
            param: $param
        );

        return function ($param = null) use ($controllerInstance, $method) {
            return $controllerInstance->$method($param);
        };
    }

    public function getRequest(): RequestHandler
    {
        return $this->request;
    }

    public function setRequest(RequestHandler $requestHandler): void
    {
        $this->request = $requestHandler;
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}

