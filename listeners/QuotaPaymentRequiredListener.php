<?

class QuotaPaymentRequiredListener implements Listener {
    public function onEvent($event) {
        // Criar notificação que aparecerá no perfil.
        QuotaHandler::getInstance()->notify(new Quota(
            $event->getQuotaId(),
            $event->getMemberId(),
            $event->getLastPaymentDate(),
            $event->getPaymentDueDate(),
            $event->getValue()
        ));
    }

    public function getType() {
        return 'QuotaPaymentRequired';
    }
}
