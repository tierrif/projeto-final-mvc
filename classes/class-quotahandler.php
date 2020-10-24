<?

class QuotaHandler {
    // Instância deste singleton.
    private static $_instance; // EventHandler.
    private static $_notifications; // Quota[].

    // Construtor privado para evitar chamadas externas.
    private function __construct() {
    }

    /*
     * Obter a instância deste
     * singleton.
     */
    public static function getInstance() {
        if (!self::$_instance) {
            // 'new self;' é o mesmo que 'new SystemDB;'.
            self::$_instance = new self;
            self::$_notifications = [];
        }
        return self::$_instance;
    }

    public function notify($quota) {
        self::$_notifications[] = $quota;
    }

    public function getNotificationsFrom($idSocio) {
        debug('ID do sócio: ' . $idSocio);
        $toReturn = [];
        foreach (self::$_notifications as $quota) {
            debug('Notificação iterada.');
            debug('ID do sócio: ' . $quota->getIdSocio());
            if ($quota->getIdSocio() === $idSocio) {
                debug('Notificação adicionada.');
                $toReturn[] = $quota;
            }
        }
        return $toReturn;
    }
}

