<?

abstract class Controller {
    private $_db; // SystemDB.
    private $_title; // string.
    private $_loggedIn; // bool.
    private $_loginRequired; // bool.
    private $_authManager; // AuthManager.
    private $_requiredPermissions; // string[].
    private $_params; // string[].
    private $_formError; // string.
    private $_formNotif; // string.
    private $_model; // Model.
    private $_userPermissions; // string[].
    private $_navPos; // string.
    private $_data; // [string => string].

    public function __construct($params = [], $title = DEFAULT_TITLE, $modelBaseName = null, $requiresAuthentication = false) {
        // Obter a instância da base de dados.
        $this->_db = SystemDB::getInstance();
        // <title></title> da view.
        $this->_title = $title;
        // Gestor de autenticação.
        $this->_authManager = AuthManager::getInstance();
        // Sessão aberta.
        $this->_loggedIn = $this->_authManager->validateSession();
        // Verifica se é necessária autenticação neste controlador.
        $this->_loginRequired = $requiresAuthentication && !$this->_loggedIn;
        // Redirecionar no caso de ser necessário login.
        if ($this->_loginRequired) $this->performAuthentication();
        // Inicializar array de permissões para o controlador.
        $this->_requiredPermissions = [];
        // Parâmetros do pedido.
        $this->_params = $params;
        // Inicializar notificações.
        $this->_formError = '';
        $this->_formNotif = '';
        // Setar o modelo, através da fábrica.
        $this->_model = $this->constructModel($modelBaseName);
        // Setar as permissões, se temos sessão.
        if ($this->_loggedIn) $this->_userPermissions = AuthManager::getInstance()->getPermissionsForSession($_SESSION['token']);
    }

    /*
     * Automaticamente requere todas
     * as views necessárias para qualquer
     * controlador.
     */
    public function view($pathToView, $hasNav = false) {
        // Carregar notificações.
        if (method_exists($this->_model, 'getFormMessage') && $this->_model->getFormMessage() && $_POST)
            $this->notif($this->_model->getFormMessage(), $this->_model->getFormMessageType() === FORM_MESSAGE_TYPE_ERROR);
        // Header necessita sempre de ser chamado.
        require HEADER_PATH;
        // Se necessitar menu de navegação, requerir.
        if ($hasNav) require NAV_PATH;
        // Requerir a view dada.
        require ABSPATH . $pathToView;
        // Footer necessita sempre de ser chamado.
        require FOOTER_PATH;
    }

    /*
     * Após reload da página, estas
     * notificações aparecerão.
     */
    public function notif($message, $error = false) {
        if ($error) $this->_formError = $message;
        else $this->_formNotif = $message;
    }

    /*
     * Adiciona ao documento na posição
     * atual as notificações.
     */
    public function useNotif() {
        require ABSPATH . '/views/_includes/notif.php';
    }

    /*
     * Incluir views necessárias para
     * a página principal do controlador.
     */
    public abstract function index();

    /*
     * Pesquisa e retorna o modelo responsável
     * por este controlador, se existir.
     * Chamar #getModel se este modelo já estiver
     * declarado pelo construtor/se tem o mesmo
     * nome que o controlador!
     *
     * $baseName - Nome do modelo (ex. login),
     * deixar null para usar o nome do controlador
     * dinamicamente.
     * Ao usar o nome do modelo, NÃO INCLUIR -MODEL.
     */
    public function constructModel($baseName = null) {
        // Instanciar a fábrica de modelos.
        $factory = new ModelFactory;
        return $factory->getModel(get_class($this), $this->_params, $baseName);
    }

    /*
     * Redireciona para login e depois para o controlador
     * desejado após sucesso em login.
     */
    public function performAuthentication() {
        // Obter o nome da classe para então ter o nome do controlador.
        $controller = str_replace('controller', '', strtolower(get_class($this)));
        // Redirecionar.
        header('Location: ' . HOME_URI . '/login/redirect/' . $controller);
    }

    /*
     * ATENÇÃO: Diferente de findModel().
     * findModel() deve ser chamado apenas
     * uma vez para o modelo do controlador.
     * Normalmente, o controlador que herda desta
     * classe deve dar o nome do modelo que vai usar
     * no caso de este ser irregular (ou seja, o nome do
     * modelo a usar ser diferente do nome do controlador).
     * Por defeito, Controller irá usar o nome do controlador
     * como base para obter o modelo. Este método retornará o
     * que for instanciado no construtor super (Controller#__construct).
     */
    public function getModel() {
        return $this->_model;
    }

    /*
     * Poderá ser chamado no caso de existirem vários
     * modelos num controlador.
     */
    public function setModel($baseName) {
        $this->_model = $this->constructModel($baseName);
    }

    /*
     * Obter todos os dados
     * adicionais da view.
     */
    public function getAllData() {
        return $this->_data;
    }

    /*
     * Obter dados adicionais para
     * a view.
     */
    public function getData($data) {
        return arrayValue($this->_data, $data);
    }

    /*
     * Setar dados adicionais para
     * a view.
     */
    public function setData($data, $value) {
        $this->_data[$data] = $value;
    }

    public function formValue($name) {
        return !$this->getModel()->fetchData($name) ? '' : $this->getModel()->fetchData($name);
    }

    /*
     * Usado em views para verificar
     * qual a página ativa na barra
     * de navegação.
     */
    public function getNavPos() {
        return $this->_navPos;
    }

    public function setNavPos($navPos) {
        $this->_navPos = $navPos;
    }

    public function getDb() {
        return $this->_db;
    }

    public function getTitle() {
        return $this->_title;
    }

    protected function setTitle($title = DEFAULT_TITLE) {
        $this->_title = $title;
    }

    public function isLoggedIn() {
        return $this->_loggedIn;
    }

    public function isLoginRequired() {
        return $this->_loginRequired;
    }

    public function getAuthManager() {
        return $this->_authManager;
    }

    public function getRequiredPermissions() {
        return $this->_requiredPermissions;
    }

    protected function setRequiredPermissions($permissions = []) {
        $this->_requiredPermissions = $permissions;
    }

    protected function addRequiredPermission($permission) {
        $this->_requiredPermissions[] = $permission;
    }

    public function getUserPermissions() {
        return $this->_userPermissions;
    }

    public function getParams() {
        return $this->_params;
    }

    public function getFormError() {
        return $this->_formError;
    }

    public function getFormNotif() {
        return $this->_formNotif;
    }
}
