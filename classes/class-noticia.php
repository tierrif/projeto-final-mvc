<?

class Noticia {
    private $_id; // int.
    private $_titulo; // string.
    private $_noticia; // string.
    private $_imagem; // Imagem.
    private $_idAssociacao; // int.

    public function __construct($id, $titulo, $noticia, $imagem, $idAssociacao) {
        $this->_id = $id;
        $this->_titulo = $titulo;
        $this->_noticia = $noticia;
        $this->_imagem = $imagem;
        $this->_idAssociacao = $idAssociacao;
    }

    public function getId() {
        return $this->_id;
    }

    public function getTitulo() {
        return $this->_titulo;
    }

    public function getNoticia() {
        return $this->_noticia;
    }

    public function getImagem() {
        return $this->_imagem;
    }

    public function getIdAssociacao() {
        return $this->_idAssociacao;
    }
}
