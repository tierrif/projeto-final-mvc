<?

class SystemDB {
    // Instância deste singleton.
    private static $_instance; // SystemDB.
    private static $_db; // PDO.

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
            // Instanciar o PDO.
            self::$_instance->connectToDatabase();
        }
        return self::$_instance;
    }

    /*
     * Contectar à base de dados.
     */
    private function connectToDatabase() {
        // Detalhes da base de dados definidos por constantes em config.php.
        $dbDetails = 'mysql:host=' . HOSTNAME . ';';
        $dbDetails .= 'dbname=' . DB_NAME . ';';
        $dbDetails .= 'charset=' . DB_CHARSET . ';';

        // Inicializar conexão.
        try {
            debug('Instanciação do PDO...');
            self::$_db = new PDO($dbDetails, DB_USER, DB_PASSWORD);
            // Verificar modo DEBUG.
            if (DEBUG) {
                // Configurar a forma como os erros são mostrados no PDO.
                self::$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
        } catch (PDOException $e) {
            if (DEBUG) {
                // Mostra a mensagem de erro.
                echo "Erro: " . $e->getMessage();
            }
            die();
        }
    }

    /*
     * Retorna a instância do PDO.
     */
    public function getPDO() {
        return self::$_db;
    }
}
