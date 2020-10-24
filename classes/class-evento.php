<?

class Evento {
    private $_id; // int.
    private $_titulo; // string.
    private $_evento; // string.
    private $_idAssociacao; // int.
    private $_data; // Date.

    public function __construct($id, $titulo, $evento, $idAssociacao, $data) {
        $this->_id = $id;
        $this->_titulo = $titulo;
        $this->_evento = $evento;
        $this->_idAssociacao = $idAssociacao;
        $this->_data = $data;
    }

    public function getId() {
        return $this->_id;
    }

    public function getTitulo() {
        return $this->_titulo;
    }

    public function getEvento() {
        return $this->_evento;
    }

    public function getIdAssociacao() {
        return $this->_idAssociacao;
    }

    public function getData() {
        return $this->_data;
    }
}
