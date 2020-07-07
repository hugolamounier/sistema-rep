<?php
class Route{

    private static $routes = Array();
    
    public static function add($expression, $path)
    {
        array_push(self::$routes, array(
            'expression' => $expression,
            'path' => $path
        ));
    }

    public static function pathExists($path)
    {
        if(file_exists($path))
        {
            return true;
        }else{
            return false;
        }
    }

    public static function run($basePath = __DIR__)
    {
        $request = parse_url($_SERVER['REQUEST_URI']);

        foreach(self::$routes as $route)
        {
            if($route['expression'] == $request['path'])
            {
                if(file_exists($basePath.$route['path']))
                {
                    require $basePath.$route['path'];
                }else{
                    self::notFound($basePath);
                }
            }
        }
    }

    public static function notFound($basePath)
    {
        http_response_code(404);
        require $basePath . '/views/404.php';
    }
}


?>