<?

class ManageNewsModel extends FormModel {
    public function __construct($db, $params) {
        parent::__construct($db, $params);
    }

    public function getFormDataElements() {
        return [
            createFormElement('titulo', 'required'),
            createFormElement('noticia'),
            createFormElement('idAssociacao', 'required|numeric')
        ];
    }

    public function onFormValidated() {
        /*
         * Para prevenir SQL injection e facilitar queries,
         * podemos usar "queries preparadas" no PDO.
         *
         * https://www.php.net/manual/en/pdo.prepared-statements.php
         */

        // Apenas variáveis devem ser passadas para parâmetros das queries.
        $titulo = $this->fetchData('titulo');
        $noticia = $this->fetchData('noticia');
        $imagem = Imagem::upload('imagem')->getNome();
        $idAssociacao = $this->fetchData('idAssociacao');

        debug($titulo);
        debug($noticia);
        debug($imagem);
        debug($idAssociacao);

        // Se existir um parâmetro, significa que há ID. Assim, não introduzimos, mas atualizamos.
        if (arrayValue($this->getParams(), 1)) {
            // Para não repor imagens antigas se não for adicionada imagem.
            $oldImagem = arrayValue($this->getById($this->getParams()[1]), 'imagem');
            // Preparar query.
            $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::UPDATE_NOTICIA);
            // Adicionar parâmetros.
            $statement->bindParam(1, $titulo);
            $statement->bindParam(2, $noticia);
            // Se não for passada imagem, não eliminar, mas usar a imagem antiga.
            if (arrayValue(arrayValue($_FILES, 'imagem'), 'name')) {
                $statement->bindParam(3, $imagem);
                // Elimina a imagem anterior.
                Imagem::delete($oldImagem);
            } else $statement->bindParam(3, $oldImagem);
            $statement->bindParam(4, $idAssociacao);
            $statement->bindParam(5, $this->getParams()[1]);
            // Executar.
            $statement->execute();
            return;
        }

        // Não existe ID, por isso introduzimos.
        // Preparar query.
        $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::INSERT_INTO_NOTICIA);

        // Adicionar parâmetros.
        $statement->bindParam(1, $titulo);
        $statement->bindParam(2, $noticia);
        $statement->bindParam(3, $imagem);
        $statement->bindParam(4, $idAssociacao);

        // Executar.
        $statement->execute();
    }

    /*
     * Eliminar a imagem fisicamente
     * se esta for eliminada da base
     * de dados.
     */
    public function onDelete($id) {
        // Obter o nome da imagem.
        $imageName = arrayValue($this->getById($id), 'imagem');
        // Eliminar.
        Imagem::delete($imageName);
    }

    public function getSelectAllQuery() {
        return DatabaseQueries::SELECT_FROM_NOTICIA;
    }

    public function getDeleteQuery() {
        return DatabaseQueries::DELETE_FROM_NOTICIA;
    }

    public function getSelectByIdQuery() {
        return DatabaseQueries::SELECT_FROM_NOTICIA_BY_ID;
    }

    public function onElementIteration($data) {
        return new Noticia($data['idNoticia'], $data['titulo'], $data['noticia'], new Imagem($data['imagem'], UP_ABSPATH . '/' . $data['imagem']), $data['idAssociacao']);
    }
}
