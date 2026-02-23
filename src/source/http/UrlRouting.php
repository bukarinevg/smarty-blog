<?php
declare(strict_types=1);

namespace app\source\http;

use app\source\exceptions\NotFoundException;

/**
 * Class UrlRouting
 *
 * This class extends the Url class and is responsible for handling URL routing.
 */
class UrlRouting extends Url
{
    private const string CONTROLLER_NAMESPACE = 'app\controllers\\';

    private const int ROUTE_ELEMENTS_WITHOUT_PARAM = 2;

    private const int ROUTE_ELEMENTS_WITH_PARAM = 3;

    public function __construct()
    {
        parent::__construct($_SERVER);
    }

    /**
     * @throws NotFoundException
     */
    public function getRouteDetails(): Route
    {
        $path = $this->path;
        $urlNamesArray = $this->parsePathToNamesArray($path);

        $route = $this->findRoute($urlNamesArray, self::ROUTE_ELEMENTS_WITHOUT_PARAM);
        if ($route) {
            return $route;
        }

        $route = $this->findRoute($urlNamesArray, self::ROUTE_ELEMENTS_WITH_PARAM);
        if ($route) {
            return $route;
        }

        $urlNamesArray[] = 'index';
        $route = $this->findRoute($urlNamesArray, self::ROUTE_ELEMENTS_WITHOUT_PARAM);
        if ($route) {
            return $route;
        }

        $urlNamesArray = ['index', 'index'];
        $route = $this->findRoute($urlNamesArray, self::ROUTE_ELEMENTS_WITHOUT_PARAM);
        if ($route) {
            return $route;
        }

        throw new NotFoundException('Controller or method not found');
    }

    private function findRoute(array $urlNamesArray, int $routeElements): ?Route
    {
        $countUrlElements = count($urlNamesArray);

        if ($countUrlElements < $routeElements) {
            return null;
        }

        $nameSpaceElementsArray = $countUrlElements > $routeElements
            ? array_slice($urlNamesArray, 0, $countUrlElements - $routeElements)
            : [];

        $nameSpace = $this->buildNameSpace($nameSpaceElementsArray);
        $routeArray = !empty($nameSpaceElementsArray)
            ? array_slice($urlNamesArray, count($nameSpaceElementsArray), $routeElements)
            : $urlNamesArray;

        $controller = $this->getControllerName($routeArray[0], $nameSpace);
        $method = $this->getMethodName($routeArray[1]);
        $param = $routeArray[2] ?? null;

        $route = new Route($controller, $method, $param);

        if ($route->validate()) {
            return $route;
        } else {
            return null;
        }
    }

    private function parsePathToNamesArray(string $url): array
    {
        if (strpos($url, '-')) {
            $trimmedUrl = ltrim($url, '-');
            $parts = explode('-', $trimmedUrl);
            $parts = array_map(function ($part) {
                return ucfirst($part);
            }, $parts);
            $url = implode('', $parts);
        }

        $url = rtrim($url, '/');
        return explode('/', ltrim($url, '/'));
    }

    private function getControllerName(string $controllerName, string $nameSpace): string
    {
        $controllerName = ucfirst($controllerName);
        return self::CONTROLLER_NAMESPACE . $nameSpace . $controllerName . 'Controller';
    }

    private function getMethodName($url = null): string
    {
        return 'action' . (ucfirst($url));
    }

    private function buildNameSpace(array $urlNamesArray): string
    {
        $nameSpace = '';
        for ($i = 0; $i < count($urlNamesArray); $i++) {
            $nameSpace .= ucfirst($urlNamesArray[$i]) . '\\';
        }
        return $nameSpace;
    }
}

