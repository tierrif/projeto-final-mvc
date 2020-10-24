<?

class AuthManager {
    // Instância deste singleton.
    private static $_instance; // AuthManager.

    private $_passwordHash;
    private $_userSessions;

    // Construtor privado para evitar chamadas externas.
    private function __construct() {
        // O construtor é chamado apenas uma vez.
        // Ajudante de encriptação de palavras passe.
        $this->_passwordHash = new PasswordHash(8, false);
        // Buscar todas as sessões da base de dados e guardá-las em memória.
        $this->_userSessions = $this->retrieveSessions();
    }

    /*
     * Obter a instância deste
     * singleton.
     */
    public static function getInstance() {
        if (!self::$_instance) {
            // 'new self;' é o mesmo que 'new AuthManager;'.
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function hashPassword($password) {
        return $this->_passwordHash->HashPassword($password);
    }

    public function checkPassword($toCheck, $hashedPassword) {
        return $this->_passwordHash->CheckPassword($toCheck, $hashedPassword);
    }

    /*
     * Verifica se a sessão é válida (ou seja,
     * se o utilizador está autenticado).
     */
    public function validateSession() {
        // Verifica se existe variável de sessão 'token'.
        if (!arrayValue($_SESSION,'token')) return false;
        // Obtém a sessão do array associativo.
        $session = arrayValue($this->_userSessions, $_SESSION['token']);
        debug('Sessão: ' . $session);
        // Retorna a sessão se esta existe, ou null se não.
        return $session;
    }

    /*
     * Cria uma sessão de autenticação
     * baseada em credenciais login.
     *
     * Retorna o token da sessão se o login for feito
     * com sucesso, ou null se não.
     */
    public function login($username = null, $password = null) {
        debug('A iniciar login...');
        // Não vale a pena atualizar a sessão se já existir uma.
        if ($this->validateSession()) return $_SESSION['token'];
        // Ambos devem ser passados.
        if (!($username && $password)) return null;
        // Query à base de dados.
        $query = SystemDB::getInstance()->getPDO()->query(DatabaseQueries::SELECT_LOGIN_SOCIO . "'$username'");
        // Verifica se falhou.
        if (!$query) {
            // Mostra se estivermos em modo debug que houve um problema.
            debug('AuthManager#login falhou ao fazer query à base de dados.');
            return null;
        }

        // Buscar dados.
        $query = $query->fetch();

        // Verifica se houve sucesso.
        $success = $this->checkPassword($password, arrayValue($query, 'password'));
        // Retorna null, não há token se o login for incorreto.
        if (!$success) return null;
        $_SESSION['token'] = sha1(md5(time()));
        $this->updateSession($_SESSION['token'], $username);
        return $_SESSION['token'];
    }

    /*
     * Esta função deve ser chamada apenas
     * uma vez, ou seja, quando o singleton
     * é instanciado. Todas as sessões serão postas
     * em memória, e quando uma sessão é criada,
     * esta será enviada para a db. Isto por razões
     * de desempenho do site, porque aceder a memória
     * é mais rápido do que fazer uma query à base de
     * dados, que muitas vezes pode ser remota.
     *
     * Retornará um array com todas as sessões.
     */
    public function retrieveSessions() {
        // Inicializa o array a retornar, que poderá retornar vazio se não houverem sessões/houver erro.
        $toReturn = [];
        // Query à base de dados.
        $query = SystemDB::getInstance()->getPDO()->query(DatabaseQueries::SELECT_FROM_SOCIO);
        // Verifica se falhou.
        if (!$query) {
            // Mostra se estivermos em modo debug que houve um problema.
            debug('AuthManager#retrieveSessions falhou ao fazer query à base de dados.');
            return $toReturn;
        }

        // Buscar dados.
        $query = $query->fetchAll();

        foreach ($query as $session) {
            // Adiciona com a sessão como chave, e valor como username, que será o dono da sessão.
            $toReturn[$session['sessao']] = $session['login'];
        }

        // Retorna as sessões encontradas.
        return $toReturn;
    }

    /*
     * Como o username de um sócio é único,
     * podemos encontrar o ID do mesmo através
     * deste username.
     *
     * Retorna o ID do user com login = $username,
     * ou null se não for encontrado sócio.
     */
    public function getUserIdByUsername($username) {
        // É necessário um username para prosseguir.
        if (!$username) return null;
        // Query à base de dados.
        $query = SystemDB::getInstance()->getPDO()->query(DatabaseQueries::SELECT_LOGIN_SOCIO . "'$username'");
        // Verifica se falhou.
        if (!$query) {
            // Mostra se estivermos em modo debug que houve um problema.
            debug('AuthManager#getUserIdByUsername falhou ao fazer query à base de dados.');
            return null;
        }

        // Buscar dados.
        $query = $query->fetch();
        return arrayValue($query, 'idSocio');
    }

    /*
     * Obtém todas as permissões para o sócio
     * com ID $userId. Caso não haja acesso direto
     * ao ID, chamar #getPermissionsForUsername.
     *
     * Retorna array de permissões (string[]).
     */
    public function getPermissionsFor($userId) {
        // É necessário um username para prosseguir.
        if (!$userId) return null;
        // Query à base de dados.
        $query = SystemDB::getInstance()->getPDO()->query(DatabaseQueries::SELECT_FROM_PERMISSIONS_BY_SOCIO_ID . "'$userId'");
        // Verifica se falhou.
        if (!$query) {
            // Mostra se estivermos em modo debug que houve um problema.
            debug('AuthManager#getPermissionsFor falhou ao fazer query à base de dados.');
            return null;
        }

        // Buscar dados.
        $query = $query->fetchAll();
        // Inicializar array de permissões.
        $toReturn = [];
        // Popular array.
        foreach ($query as $permission) $toReturn[] = $permission['nome'];

        return $toReturn;
    }

    /*
     * Se não houver ID, buscar à base de dados
     * através de #getUserIdByUsername.
     *
     * Alternativa a #getPermissionsFor.
     */
    public function getPermissionsForUsername($username) {
        return $this->getPermissionsFor($this->getUserIdByUsername($username));
    }

    /*
     * Se não houver username, simplesmente buscar
     * a sessão à memória ($_userSessions).
     *
     * Alternativa a #getPermissionsFor.
     */
    public function getPermissionsForSession($sessionId) {
        return $this->getPermissionsForUsername($this->getUser());
    }

    public function hasPermission($permission) {
        return in_array($permission, $this->getPermissionsForSession($_SESSION['token']));
    }

    /*
     * Obter o username na sessão corrente
     * ou null se não houver sessão.
     */
    public function getUser() {
        return arrayValue($this->_userSessions, arrayValue($_SESSION, 'token'));
    }

    public function updateSession($session, $username) {
        // Atualizar a variável de sessão para o cliente.
        $_SESSION['token'] = (!$session ? null : $session); // Se $session é '', eliminar a sessão completamente.
        // Atualizar a variável de userSessions.
        $this->_userSessions[$_SESSION['token']] = $username;
        // Criar a string de query baseada na constante.
        $toQuery = DatabaseQueries::UPDATE_SESSIONS_SOCIO;
        // Adicionar a sessão.
        $toQuery .= "'$session'";
        // Adicionar a cláusula WHERE.
        $toQuery .= ' WHERE login = ' . "'$username'";
        // Query à base de dados. Não pode correr mal se a query chamada anteriormente funcionou.
        SystemDB::getInstance()->getPDO()->query($toQuery);
    }
}
