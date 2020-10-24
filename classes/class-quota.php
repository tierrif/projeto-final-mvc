<?

class Quota {
    private $_id; // int.
    private $_idSocio; // int.
    private $_dataComeco; // date.
    private $_dataTermino; // date.
    private $_preco; // float.

    public function __construct($id, $idSocio, $dataComeco, $dataTermino, $preco) {
        $this->_id = $id;
        $this->_idSocio = $idSocio;
        $this->_dataComeco = $dataComeco;
        $this->_dataTermino = $dataTermino;
        $this->_preco = $preco;
    }

    public function getId() {
        return $this->_id;
    }

    public function getIdSocio() {
        return $this->_idSocio;
    }

    public function getDataComeco() {
        return $this->_dataComeco;
    }

    public function getDataTermino() {
        return $this->_dataTermino;
    }

    public function getPreco() {
        return $this->_preco;
    }

    public static function getAllFromSocio($id) {
        // Query à base de dados.
        $query = SystemDB::getInstance()->getPDO()->query(DatabaseQueries::SELECT_FROM_QUOTA_BY_SOCIO_ID . $id);
        // Verificar se falhou.
        if (!$query) {
            debug('Query falhou: ' . DatabaseQueries::SELECT_FROM_QUOTA);
            return null;
        }

        $toReturn = []; // Associacao[].
        foreach ($query->fetchAll() as $data) {
            $toReturn[] = new self($data['idQuota'], $data['idSocio'], $data['dataComeco'], $data['dataTermino'], $data['preco']);
        }

        return $toReturn;
    }
}
