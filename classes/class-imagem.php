<?

class Imagem {
    private $_nome; // string.
    private $_path; // string.

    // Usar ::upload() para instanciar.
    public function __construct($nome, $path) {
        $this->_nome = $nome;
        $this->_path = $path;
    }

    public function getNome() {
        return $this->_nome;
    }

    public function getPath() {
        return $this->_path;
    }

    /*
     * Faz upload e cria uma instância
     * da própria classe.
     */
    public static function upload($name = 'imagem') {
        $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
        $newName = sha1(time()); // Nome único.
        move_uploaded_file($_FILES[$name]['tmp_name'], UP_ABSPATH . $newName . '.' . $ext); // Mover o ficheiro.
        return new self($newName . '.' . $ext, UP_ABSPATH . $newName . '.' . $ext);
    }

    /*
     * Elimina a imagem com o nome $name.
     */
    public static function delete($name) {
        if (!is_dir('views/_uploads')) return false;
        return unlink("views/_uploads/$name");
    }
}
