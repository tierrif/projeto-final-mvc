<?

// Evita que alguém aceda a este ficheiro diretamente.
if (!defined('ABSPATH')) exit;

// Inicia a sessão.
session_start();
// Verifica o modo para debug.
if (!defined('DEBUG') || DEBUG === false) {
    // Debug OFF: Esconder qualquer tipo de erro.
    error_reporting(0);
    // Alterar a configuração no ficheiro php.ini.
    ini_set('display_errors', 0);
} else {
    // Debug ON: Mostrar todos os erros.
    error_reporting(E_ALL);
    // Alterar a configuração no ficheiro php.ini.
    ini_set('display_errors', 1);
}

// Funções globais.
require_once ABSPATH . '/functions/global-functions.php';

// Carrega a aplicação.
$system = new System();
