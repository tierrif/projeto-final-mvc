<?

class ManageEventosModel extends FormModel {
    public function __construct($db, $params) {
        parent::__construct($db, $params);
    }

    public function getFormDataElements() {
        return [
            createFormElement('idAssociacao', 'required'),
            createFormElement('titulo', 'required'),
            createFormElement('evento'),
            createFormElement('data', 'required')
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
        $idAssociacao = $this->fetchData('idAssociacao');
        $titulo = $this->fetchData('titulo');
        $evento = $this->fetchData('evento');
        $data = $this->fetchData('data');

        debug($idAssociacao);
        debug($titulo);
        debug($evento);
        debug($data);

        // Neste caso em específico, é necessário converter a data.
        $data = $this->invertDate($data);

        // Se existir um parâmetro, significa que há ID. Assim, não introduzimos, mas atualizamos.
        if (arrayValue($this->getParams(), 0)) {
            // Preparar query.
            $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::UPDATE_EVENTO);
            // Adicionar parâmetros.
            $statement->bindParam(1, $idAssociacao);
            $statement->bindParam(2, $titulo);
            $statement->bindParam(3, $evento);
            $statement->bindParam(4, $data);
            $statement->bindParam(5, $this->getParams()[1]);
            // Executar.
            $statement->execute();
            return;
        }

        // Não existe ID, por isso introduzimos.
        // Preparar query.
        $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::INSERT_INTO_EVENTO);

        // Adicionar parâmetros.
        $statement->bindParam(1, $idAssociacao);
        $statement->bindParam(2, $titulo);
        $statement->bindParam(3, $evento);
        $statement->bindParam(4, $data);

        // Executar.
        $statement->execute();
    }

    public function getSelectAllQuery() {
        return DatabaseQueries::SELECT_FROM_EVENTO;
    }

    public function getDeleteQuery() {
        return DatabaseQueries::DELETE_FROM_EVENTO;
    }

    public function getSelectByIdQuery() {
        return DatabaseQueries::SELECT_FROM_EVENTO_BY_ID;
    }

    public function onElementIteration($data) {
        return new Evento($data['idEvento'], $data['titulo'], $data['evento'], $data['idAssociacao'], $data['data']);
    }
}
