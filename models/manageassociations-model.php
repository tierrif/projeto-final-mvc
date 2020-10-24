<?

class ManageAssociationsModel extends FormModel {
    public function __construct($db, $params) {
        parent::__construct($db, $params);
    }

    public function getFormDataElements() {
        return [
            createFormElement('nome', 'required'),
            createFormElement('morada'),
            createFormElement('telefone', 'numeric'),
            createFormElement('numContribuinte', 'required|numeric')
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
        $morada = $this->fetchData('morada');
        $telefone = $this->fetchData('telefone');
        $contribuinte = $this->fetchData('numContribuinte');

        debug($nome);
        debug($morada);
        debug($telefone);
        debug($contribuinte);

        // Se existir um parâmetro, significa que há ID. Assim, não introduzimos, mas atualizamos.
        if (arrayValue($this->getParams(), 0)) {
            // Preparar query.
            $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::UPDATE_ASSOCIACAO);
            // Adicionar parâmetros.
            $statement->bindParam(1, $nome);
            $statement->bindParam(2, $morada);
            $statement->bindParam(3, $telefone);
            $statement->bindParam(4, $contribuinte);
            $statement->bindParam(5, $this->getParams()[1]);
            // Executar.
            $statement->execute();
            return;
        }

        // Não existe ID, por isso introduzimos.
        // Preparar query.
        $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::INSERT_INTO_ASSOCIACAO);

        // Adicionar parâmetros.
        $statement->bindParam(1, $nome);
        $statement->bindParam(2, $morada);
        $statement->bindParam(3, $telefone);
        $statement->bindParam(4, $contribuinte);

        // Executar.
        $statement->execute();
    }

    public function getSelectAllQuery() {
        return DatabaseQueries::SELECT_FROM_ASSOCIACAO;
    }

    public function getDeleteQuery() {
        return DatabaseQueries::DELETE_FROM_ASSOCIACAO;
    }

    public function getSelectByIdQuery() {
        return DatabaseQueries::SELECT_FROM_ASSOCIACAO_BY_ID;
    }

    public function onElementIteration($data) {
        return new Associacao($data['idAssociacao'], $data['nome'], $data['morada'], $data['telefone'], $data['numContribuinte']);
    }
}
