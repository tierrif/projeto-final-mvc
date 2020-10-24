<?

class Associacao {
    private $_id; // int.
    private $_nome; // string.
    private $_morada; // string.
    private $_telefone; // int.
    private $_numContribuinte; // int.

    public function __construct($id, $nome, $morada, $telefone, $numContribuinte) {
        $this->_id = $id;
        $this->_nome = $nome;
        $this->_morada = $morada;
        $this->_telefone = $telefone;
        $this->_numContribuinte = $numContribuinte;
    }

    public function getId() {
        return $this->_id;
    }

    public function getNome() {
        return $this->_nome;
    }

    public function getMorada() {
        return $this->_morada;
    }

    public function getTelefone() {
        return $this->_telefone;
    }

    public function getNumContribuinte() {
        return $this->_numContribuinte;
    }

    public static function getAll() {
        // Query à base de dados.
        $query = SystemDB::getInstance()->getPDO()->query(DatabaseQueries::SELECT_FROM_ASSOCIACAO);
        // Verificar se falhou.
        if (!$query) {
            debug('Query falhou: ' . DatabaseQueries::SELECT_FROM_ASSOCIACAO);
            return null;
        }

        $toReturn = []; // Associacao[].
        foreach ($query->fetchAll() as $data) {
            $toReturn[] = new self($data['idAssociacao'], $data['nome'], $data['morada'], $data['telefone'], $data['numContribuinte']);
        }

        return $toReturn;
    }
}
