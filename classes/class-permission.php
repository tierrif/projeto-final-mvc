<?

class Permission {
    private $_id;
    private $_idSocio;
    private $_nome;

    public function __construct($id, $idSocio, $nome) {
        $this->_id = $id;
        $this->_idSocio = $idSocio;
        $this->_nome = $nome;
    }

    public function getId() {
        return $this->_id;
    }

    public function getIdSocio() {
        return $this->_idSocio;
    }

    public function getNome() {
        return $this->_nome;
    }

    public function findOwner() {
        // Query à base de dados.
        $query = SystemDB::getInstance()->getPDO()->query(DatabaseQueries::SELECT_FROM_SOCIO_BY_ID . $this->_idSocio);
        if (!$query) {
            debug('Permission#findOwner falhou na query.');
            return null;
        }
        return $query->fetch()['login'];
    }
}
