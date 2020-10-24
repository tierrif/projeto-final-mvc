<?

class ManageMembersModel extends FormModel {
    public function __construct($db, $params) {
        parent::__construct($db, $params);
    }

    public function getFormDataElements() {
        return [
            createFormElement('nome', 'required'),
            createFormElement('email'),
            createFormElement('login', 'required'),
            createFormElement('password', 'required'),
            createFormElement('idAssociacao', 'required|numeric'),
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
        $email = $this->fetchData('email');
        $login = $this->fetchData('login');
        $password = AuthManager::getInstance()->hashPassword($this->fetchData('password'));
        $idAssociacao = $this->fetchData('idAssociacao');

        debug($nome);
        debug($email);
        debug($idAssociacao);

        // Se existir um parâmetro, significa que há ID. Assim, não introduzimos, mas atualizamos.
        if (arrayValue($this->getParams(), 0)) {
            // Preparar query.
            $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::UPDATE_SOCIO);
            // Adicionar parâmetros.
            $statement->bindParam(1, $nome);
            $statement->bindParam(2, $email);
            $statement->bindParam(3, $login);
            $statement->bindParam(4, $password);
            $statement->bindParam(5, $idAssociacao);
            $statement->bindParam(6, $this->getParams()[1]);
            // Executar.
            $statement->execute();
            return;
        }

        // Não existe ID, por isso introduzimos.
        // Preparar query.
        $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::INSERT_INTO_SOCIO);

        // Adicionar parâmetros.
        $statement->bindParam(1, $nome);
        $statement->bindParam(2, $email);
        $statement->bindParam(3, $login);
        $statement->bindParam(4, $password);
        $statement->bindParam(5, $idAssociacao);

        // Executar.
        $statement->execute();
    }

    public function getSelectAllQuery() {
        return DatabaseQueries::SELECT_FROM_SOCIO;
    }

    public function getDeleteQuery() {
        return DatabaseQueries::DELETE_FROM_SOCIO;
    }

    public function getSelectByIdQuery() {
        return DatabaseQueries::SELECT_FROM_SOCIO_BY_ID;
    }

    public function onElementIteration($data) {
        return new Socio($data['idSocio'], $data['nome'], $data['email'], $data['login'], $data['password'], $data['idAssociacao'], $data['sessao']);
    }
}
