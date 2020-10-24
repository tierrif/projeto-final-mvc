<?

class System {
    private $_controller; // string | Controller.
    private $_action; // string.
    private $_params; // string[].

    const NOT_FOUND = '/views/_includes/404.php';

    public function __construct() {
        // Obtém os valores do controlador, ação e parâmetros da URL.
        // Configura as propriedades da classe.
        $this->getUrlData();
        /*
         * Verifica se o controlador existe. Caso contrário,
         * adiciona o controlador padrão (controllers/home-controller.php)
         * e chama o método index().
         */
        if (!$this->_controller) {
            require_once ABSPATH . '/controllers/home-controller.php';
            // Cria o objeto do controlador 'home-controller.php'
            // Este controlador deverá ter uma classe chamada HomeController.
            $this->_controller = new HomeController;
            $this->_controller->setNavPos('');
            if (method_exists($this->_controller, 'index')) {
                $this->_controller->index();
            } else {
                $this->err404();
            }
            return;
        }
        // Se o ficheiro de controlador não existe retorna com a página 404.
        if (!file_exists(ABSPATH . "/controllers/$this->_controller.php")) {
            debug('Controller does not exist.');
            $this->err404();
            return;
        }

        require_once ABSPATH . '/controllers/' . $this->_controller . '.php';
        $this->_controller = preg_replace('/[^a-zA-Z]/i', '', $this->_controller);

        if (!class_exists($this->_controller)) {
            debug('Class does not exist in the controller file.');
            $this->err404();
            return;
        }

        $controllerName = str_replace('controller', '', $this->_controller);
        $this->_controller = new $this->_controller($this->_params);
        foreach ($this->_controller->getRequiredPermissions() as $permission) {
            if (!in_array(strtolower($permission), AuthManager::getInstance()->getPermissionsForUsername(AuthManager::getInstance()->getUser()))) {
                debug($permission);
                http_response_code(403);
                require ABSPATH . '/views/_includes/403.php';
                return;
            }
        }
        // Remove caracteres inválidos do nome da ação.
        $this->_action = preg_replace('/[^a-zA-Z]/i', '', $this->_action);
        // Se o método indicado existir, executa o método e envia os parâmetros.
        if (method_exists($this->_controller, $this->_action)) {
            $this->_controller->setNavPos($controllerName . '/' . $this->_action);
            $this->_controller->{$this->_action}($this->_params);
            return;
        }

        if (!$this->_action && method_exists($this->_controller, 'index')) {
            $this->_controller->setNavPos($controllerName);
            $this->_controller->index($this->_params);
            return;
        }

        $this->err404();
    }

    /*
     * Passa parâmetros de $_GET['path'] para, respetivamente,
     * o controlador (0), a ação (1) e os parâmetros (2+).
     * http://www.example.com/controller/action/param1/param2/param3
     */
    public function getUrlData() {
        if (isset($_GET['path'])) {
            // Captura o valor de $GET['path'].
            $path = $_GET['path'];
            $path = rtrim($path, '/');
            $path = filter_var($path, FILTER_SANITIZE_URL);
            $path = explode('/', $path);
            $this->_controller = arrayValue($path, 0); // Índice 0 do array, representa o controlador, por exemplo: projetos.
            $this->_controller .= '-controller';
            debug($this->_controller);
            $this->_action = arrayValue($path, 1);
            // Índice 1 do array, representa a ação sobre o controlador, exemplo: add, rem.
            if (arrayValue($path, 2)) {
                unset($path[0]);
                unset($path[1]);
                // /controlador/ação/param1/param2 -> /param1/param2.
                $this->_params = array_values($path);
            }
        }
    }

    /*
     * Redireciona para a página do
     * erro 404, assim como envia
     * o erro 404 HTTP.
     */
    public function err404() {
        // https://www.php.net/manual/en/function.http-response-code.php
        http_response_code(404);
        require ABSPATH . self::NOT_FOUND;
    }
}
