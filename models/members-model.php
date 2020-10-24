<?

/*
 * Este modelo não extende DisplayModel
 * devido ao facto de este não ser mostrado
 * ao público.
 */
class MembersModel extends Model {
    public function __construct($db, $params) {
        parent::__construct($db, $params);
    }

    public function verifyQuotaPayment($id) {
        // Query à base de dados.
        $query = $this->getDb()->getPDO()->query(DatabaseQueries::SELECT_FROM_QUOTA_BY_SOCIO_ID . $id);
        if (!$query) {
            debug('SociosModel#verifyQuotaPayment falhou devido à query.');
            return;
        }
        $quotas = $query->fetchAll();
        foreach ($quotas as $quota) {
            $now = date('Y-m-d');
            if ($now >= $quota['dataTermino']) {
                debug('A disparar evento QuotaPaymentRequired...');
                EventHandler::getInstance()->fireEvent('QuotaPaymentRequired', new QuotaPaymentRequiredEvent(
                    $quota['idQuota'],
                    $quota['preco'],
                    $quota['dataComeco'],
                    $quota['dataTermino'],
                    $quota['idSocio']
                ));
            }
        }
    }

    public function getSubscriptions($id) {
        /*
         * Era igual se a query fosse feita através do ID
         * do sócio ou do evento.
         * Neste caso é mais conveniente fazer a query
         * com cláusula WHERE com o ID do sócio porque
         * é de acesso mais simples, mas nada impede-nos de
         * usar o ID do evento e depois iterar todos os sócios,
         * uma vez que Inscricoes é uma tabela que faz a relação
         * N-N entre Socio e Evento.
         */
        // Query à base de dados.
        $query = $this->getDb()->getPDO()->query(DatabaseQueries::SELECT_FROM_INSCRICAO . $id);
        if (!$query) {
            debug('SociosModel#getSubscriptions falhou devido à query (Inscrições).');
            return [];
        }
        $subscriptions = $query->fetchAll();

        // Outra query à base de dados, para obter todos os eventos.
        $query = $this->getDb()->getPDO()->query(DatabaseQueries::SELECT_FROM_EVENTO);
        if (!$query) {
            debug('SociosModel#getSubscriptions falhou devido à query (Eventos).');
            return [];
        }
        $events = $query->fetchAll();

        $toReturn = [];
        foreach ($subscriptions as $subscription) {
            foreach ($events as $event) {
                if ($event['idEvento'] === $subscription['idEvento']) $toReturn[$event['idEvento']] = $event['titulo'];
            }
        }

        return $toReturn;
    }

}
