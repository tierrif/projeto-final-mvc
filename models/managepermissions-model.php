<?

class ManagePermissionsModel extends FormModel {
    public function __construct($db, $params) {
        parent::__construct($db, $params);
    }

    public function getFormDataElements() {
        return [
            createFormElement('idSocio', 'required|numeric'),
            createFormElement('nome', 'required')
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
        $nome = $this->fetchData('nome');
        $idSocio = $this->fetchData('idSocio');

        debug($nome);
        debug($idSocio);

        // Se existir um parâmetro, significa que há ID. Assim, não introduzimos, mas atualizamos.
        if (arrayValue($this->getParams(), 0)) {
            // Preparar query.
            $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::UPDATE_PERMISSION);
            // Adicionar parâmetros.
            $statement->bindParam(1, $nome);
            $statement->bindParam(2, $idSocio);
            $statement->bindParam(3, $this->getParams()[1]);
            // Executar.
            $statement->execute();
            return;
        }

        // Não existe ID, por isso introduzimos.
        // Preparar query.
        $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::INSERT_INTO_PERMISSION);

        // Adicionar parâmetros.
        $statement->bindParam(1, $nome);
        $statement->bindParam(2, $idSocio);

        // Executar.
        $statement->execute();
    }

    public function getSelectAllQuery() {
        return DatabaseQueries::SELECT_FROM_PERMISSION;
    }

    public function getDeleteQuery() {
        return DatabaseQueries::DELETE_FROM_PERMISSION;
    }

    public function getSelectByIdQuery() {
        return DatabaseQueries::SELECT_FROM_PERMISSION_BY_ID;
    }

    public function onElementIteration($data) {
        return new Permission($data['idPermission'], $data['idSocio'], $data['nome']);
    }
}
