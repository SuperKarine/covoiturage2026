<?php

namespace App\Routing;

use App\Controller\ErrorController;
use Exception;

class Router
{
    private $routes = [];
    
    public function __construct()
    {
        error_log("Router: Constructeur appelé");
        // Constructeur vide - ne charge plus de fichier
    }

    public function get(string $url, string $controllerAction, ?string $name = null): self
    {
        error_log("Router: Ajout route GET '$url' -> '$controllerAction'");
        
        [$controller, $action] = explode('@', $controllerAction);
        $this->routes[$url] = [
            "controller" => "App\Controller\\" . $controller,
            "action" => $action
        ];
        
        error_log("Router: Route ajoutée: " . print_r($this->routes[$url], true));
        return $this;
    }

    public function post(string $url, string $controllerAction, ?string $name = null): self
    {
        error_log("Router: Ajout route POST '$url' -> '$controllerAction'");
        
        [$controller, $action] = explode('@', $controllerAction);
        $this->routes[$url] = [
            "controller" => "App\Controller\\" . $controller,
            "action" => $action
        ];
        return $this;
    }

    public function handleRequest(string $uri)
    {
        try {
            error_log("Router: handleRequest appelé avec URI: '$uri'");
            
            $path = $this->normalizePath($uri);
            
            error_log("Router: Path normalisé: '$path'");
            error_log("Router: Nombre de routes: " . count($this->routes));
            error_log("Router: Routes: " . print_r(array_keys($this->routes), true));
    
            // DEBUG COMPLET HTML
            echo "<!-- Router Debug Start -->";
            echo "<!-- URI: $uri -->";
            echo "<!-- Path normalisé: $path -->";
            echo "<!-- Nombre de routes: " . count($this->routes) . " -->";
            echo "<!-- Routes: " . implode(', ', array_keys($this->routes)) . " -->";
            echo "<!-- Router Debug End -->";
    
            if (!isset($this->routes[$path])) {
                $available = implode(', ', array_keys($this->routes));
                error_log("Router: Route '$path' non trouvée. Disponibles: $available");
                throw new Exception("La route '$path' n'existe pas. Routes disponibles: $available");
            }
            
            $route = $this->routes[$path];
            error_log("Router: Route trouvée: " . print_r($route, true));
            
            $controllerPath = $route["controller"];
            $action = $route["action"];

            error_log("Router: Tentative d'instanciation: $controllerPath");
            
            if (!class_exists(($controllerPath))) {
                error_log("Router: Classe non trouvée: $controllerPath");
                throw new Exception("La classe $controllerPath n'existe pas");
            }
            
            $controller = new $controllerPath();
            error_log("Router: Contrôleur instancié: " . get_class($controller));
            
            if (!method_exists($controller, $action)) {
                error_log("Router: Méthode non trouvée: $action dans " . get_class($controller));
                throw new Exception("La méthode $action n'existe pas dans $controllerPath");
            }

            error_log("Router: Appel de $controllerPath::$action()");
            
            // Vérifie si la route a une vue à passer
            if (isset($route['view'])) {
                $controller->$action($route['view']);
            } else {
                $controller->$action();
            }
            
            error_log("Router: Appel terminé avec succès");
            
        } catch(Exception $e) {
            error_log("Router: Exception: " . $e->getMessage());
            $errorController = new ErrorController();
            $errorController->show($e->getMessage());
        }
    }

    public static function normalizePath(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = rtrim($path, "/");
        
        if (empty($path)) {
            return '/';
        }
        
        if ($path[0] !== '/') {
            $path = '/' . $path;
        }
        
        return $path;
    }

    public function match(string $url, string $view, ?string $name = null): self
    {
        error_log("Router: Ajout route MATCH '$url' -> '$view'");
        
        $this->routes[$url] = [
            "controller" => "App\Controller\PageController",
            "action" => "renderView",
            "view" => $view
        ];
        return $this;
    }
}