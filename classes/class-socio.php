<?

class Socio {
    private $_id; // int.
    private $_nome; // string.
    private $_email; // string.
    private $_login; // string.
    private $_password; // string.
    private $_idAssociacao; // int.
    private $_sessao; // string.

    public function __construct($id, $nome, $email, $login, $password, $idAssociacao, $sessao) {
        $this->_id = $id;
        $this->_nome = $nome;
        $this->_email = $email;
        $this->_login = $login;
        $this->_password = $password;
        $this->_idAssociacao = $idAssociacao;
        $this->_sessao = $sessao;
    }

    public function getId() {
        return $this->_id;
    }

    public function getNome() {
        return $this->_nome;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function getLogin() {
        return $this->_login;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function getIdAssociacao() {
        return $this->_idAssociacao;
    }

    public function getSessao() {
        return $this->_sessao;
    }

    public static function getAll() {
        // Query à base de dados.
        $query = SystemDB::getInstance()->getPDO()->query(DatabaseQueries::SELECT_FROM_SOCIO);
        // Verificar se falhou.
        if (!$query) {
            debug('Query falhou: ' . DatabaseQueries::SELECT_FROM_SOCIO);
            return null;
        }

        $toReturn = []; // Associacao[].
        foreach ($query->fetchAll() as $data) {
            $toReturn[] = new self($data['idSocio'], $data['nome'], $data['email'], $data['login'], $data['password'], $data['idAssociacao'], $data['sessao']);
        }

        return $toReturn;
    }
}
