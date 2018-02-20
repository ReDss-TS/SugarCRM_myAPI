<?php

class CoreRouter
{
    private $routes;

    // default controller Name/controller action Name
    private $defControllerName;
    private $defActionName;

    public function __construct()
    {
        $routesPath = 'Config/routes.php';
        $defControllerAction = include('Config/defController.php');
        
        $this->routes = include($routesPath);
        $this->defControllerName = $defControllerAction['controller'];
        $this->defActionName = $defControllerAction['action'];
    }

    public function start()
    {
        $uri = $this->getURI();
        $uri = explode('/', rtrim(filter_var($uri, FILTER_SANITIZE_URL), '/'));
        foreach ($uri as $key => $value) {
            $explodeString = explode(':', rtrim(filter_var($value, FILTER_SANITIZE_URL), '/'));
            if (count($explodeString) > 1){
                unset($uri[$key]);
                $uri[$explodeString[0]] = $explodeString[1];               
            }
        }
        $uri[0] = (empty($uri[0])) ? $this->defControllerName : $uri[0];
        $uri[1] = (empty($uri[1])) ? $this->defActionName : $uri[1];
        $componentsNames = $this->checkRoutes($uri[0]);
        $componentsNames = ($componentsNames == false) ? $this->getNames($uri) : $componentsNames;
        try {
            $this->callController($componentsNames, $uri);
        } catch (ExceptionErrorPage $e) {
            $e->createErrorPage('404');
        }    
    }

    /**
     * Returns REQUEST string
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
        return null;
    }

    /**
     * Find out names of controller, action and view in routes file
     * @param array $uri With uri
     * @return array or false;
     */
    private function checkRoutes($uri)
    {
        $names = [];
        foreach ($this->routes as $uriPattern => $value) {
            if ($uri == $uriPattern) {
                $names['controller'] = 'Controller' . ucfirst($value['controller']);
                $names['action']     = 'action' . ucfirst($value['action']);
                $names['view']       = 'View' . ucfirst($value['controller']) . ucfirst($value['action']);
                $names['parametersURI'] = '';
            } else {
                return false;
            }
        }
        return $names;
    }

    /**
     * Find out names of controller, action and view in user uri
     * @param array $uri With uri
     * @return array
     */
    private function getNames($uri)
    {
        $names = [];
        $names['controller'] = 'Controller' . ucfirst($uri[0]);
        $names['action']     = 'action' . ucfirst($uri[1]);
        $names['view']       = 'View' . ucfirst($uri[0]) . ucfirst($uri[1]);

        unset($uri[0], $uri[1]);
        ksort($uri);
        $names['parametersURI'] = (!empty($uri)) ? $uri : '';

        return $names;
    }

    /**
     * Call controller action
     * @param array $names With names of controller, action and view
     * @param array $uri With address bar data
     */
    private function callController($names, $uri)
    {
        $action = $names['action'];
        if (!class_exists($names['controller'])) {
            throw new ExceptionErrorPage();
        }
        if (!method_exists($names['controller'], $names['action'])) {
            throw new ExceptionErrorPage();
        }
        $uri = $uri[0] . '/' . $uri[1];
        $controllerObject = new $names['controller'];
        $controllerObject->beforeCallAction($action, $names['parametersURI']);
        $dataForPage = $controllerObject->$action($names['parametersURI']);
        $dataForPage['uri'] = $uri;
        $dataForPage['menuItems'] = include('Config/menuItems.php');
        $viewRenderObject = new ViewRender($names['view'], $dataForPage);
    }

}
