<?

class SubscribeModel extends Model {
    public function __construct($db, $params) {
        parent::__construct($db, $params);
    }

    public function createSubscription($eventId) {
        // Preparar query.
        $statement = $this->getDb()->getPDO()->prepare(DatabaseQueries::INSERT_INTO_INSCRICAO);

        // Adicionar parâmetros.
        $statement->bindParam(1, AuthManager::getInstance()->getUserIdByUsername(AuthManager::getInstance()->getUser()));
        $statement->bindParam(2, $eventId);

        // Executar.
        $statement->execute();
    }

    public function deleteSubscription($eventId) {
        // Query à base de dados.
        $query = $this->getDb()->getPDO()->query(DatabaseQueries::DELETE_FROM_INSCRICAO . $eventId);
        if (!$query) {
            debug('Query falhou em SubscribeModel#deleteSubscription.');
            return;
        }
        $query->fetch();
    }
}
