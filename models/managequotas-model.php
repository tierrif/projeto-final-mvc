<?

class ManageQuotasModel extends FormModel {
    public function __construct($db, $params) {
        parent::__construct($db, $params);
    }

    public function getFormDataElements() {
        return [
            createFormElement('idSocio', 'required|numeric'),
            createFormElement('dataComeco', 'required'),
            createFormElement('dataTermino', 'required'),
            createFormElement('preco', 'required|numeric'),
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
        $idSocio = $this->fetchData('idSocio');
        $dataComeco = $this->fetchData('dataComeco');
        $dataTermino = $this->fetchData('dataTermino');
        $preco = $this->fetchData('preco');

        debug($idSocio);
        debug($dataComeco);
        debug($dataTermino);
        debug($preco);

        // Neste caso em específico, é necessário converter a data.
        $dataComeco = $this->invertDate($dataComeco);
        $dataTermino = $this->invertDate($dataTermino);

        // Se existir um parâmetro, significa que há ID. Assim, não introduzimos, mas atualizamos.
        if (arrayValue($this->getParams(), 0)) {
            // Preparar query.
            $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::UPDATE_QUOTA);
            // Adicionar parâmetros.
            $statement->bindParam(1, $idSocio);
            $statement->bindParam(2, $dataComeco);
            $statement->bindParam(3, $dataTermino);
            $statement->bindParam(4, $preco);
            $statement->bindParam(5, $this->getParams()[1]);
            // Executar.
            $statement->execute();
            return;
        }

        // Não existe ID, por isso introduzimos.
        // Preparar query.
        $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::INSERT_INTO_QUOTA);

        // Adicionar parâmetros.
        $statement->bindParam(1, $idSocio);
        $statement->bindParam(2, $dataComeco);
        $statement->bindParam(3, $dataTermino);
        $statement->bindParam(4, $preco);

        // Executar.
        $statement->execute();
    }

    public function getSelectAllQuery() {
        return DatabaseQueries::SELECT_FROM_QUOTA;
    }

    public function getDeleteQuery() {
        return DatabaseQueries::DELETE_FROM_QUOTA;
    }

    public function getSelectByIdQuery() {
        return DatabaseQueries::SELECT_FROM_QUOTA_BY_ID;
    }

    public function onElementIteration($data) {
        return new Quota($data['idQuota'], $data['idSocio'], $data['dataComeco'], $data['dataTermino'], $data['preco']);
    }
}
