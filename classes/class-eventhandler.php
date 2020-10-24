<?

class EventHandler {
    // Instância deste singleton.
    private static $_instance; // EventHandler.
    private static $_listeners; // Listener[].

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
            // Registar os eventos.
            self::$_instance->registerEvents();
        }
        return self::$_instance;
    }

    /*
     * Dispara evento de tipo $type com
     * dados adicionais através de uma
     * instância de uma classe que herde
     * Event.
     */
    public function fireEvent($type, $eventInstance) {
        foreach (self::$_listeners as $listener) {
            if (strtolower($listener->getType()) === strtolower($type)) $listener->onEvent($eventInstance);
        }
    }

    /*
     * Registar os eventos.
     */
    private function registerEvents() {
        self::$_listeners[] = new QuotaPaymentRequiredListener();
    }
}
