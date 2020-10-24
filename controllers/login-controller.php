<?

/*
 * Controlador para o login.
 */

class LoginController extends Controller {
    public function __construct($params = []) {
        // Construtor de Controller com parâmetros da URI e título da view.
        parent::__construct($params, 'Login');
    }

    public function index() {
        // Verificar o form de login.
        $this->getModel()->validateForm('profile');
        // Requerir a view para este controlador.
        $this->view('/views/login/login-view.php');
    }

    /*
     * Ação responsável por redirecionar após
     * login feito. Chamado quando é necessário
     * login antes de entrar num controlador específico.
     */
    public function redirect() {
        // Obter o primeiro parâmetro passado.
        $controllerToRedirect = arrayValue($this->getParams(), 0);
        if (!$controllerToRedirect) $controllerToRedirect = 'profile';
        debug($controllerToRedirect);
        // Verificar o form de login. Adicionar o controlador a redirecionar.
        $this->getModel()->validateForm($controllerToRedirect);
        // Requerir a view para este controlador.
        $this->view('/views/login/login-view.php');
    }

    /*
     * Ação responsável por eliminar uma
     * sessão atual por pedido do utilizador.
     */
    public function logout() {
        $auth = $this->getAuthManager();
        $auth->updateSession('', $auth->getUser()); // session = '' elimina a sessão, porque '' == false
        // Redireciona.
        header('Location: ' . HOME_URI);
    }
}
