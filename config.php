<?

/**
 * Configuração geral.
 * Todos os dados variáveis em
 * servidor são alterados aqui.
 */

// Caminho-mãe do projeto.
define('ABSPATH', dirname(__FILE__));

// Caminho para a pasta de uploads.
define('UP_ABSPATH', ABSPATH . '\\views\\_uploads\\');

// URI da home.
define('HOME_URI', 'http://localhost/ProjetoFinalMVC');

// Nome do host.
define('HOSTNAME', 'localhost');

// Nome da DB.
define('DB_NAME', 'projeto-final-mvc');

// Utilizador da DB.
define('DB_USER', 'root');

// Password da DB.
define('DB_PASSWORD', '');

// Charset da comunicação.
define('DB_CHARSET', 'utf8');

// Se o title do controlador não estiver definido, usar este.
define('DEFAULT_TITLE', 'Projeto Final MVC');

// Caminho para a view com o cabeçalho de todas as views.
define('HEADER_PATH', ABSPATH . '/views/_includes/header.php');

// Caminho para a view responsável pela barra de navegação do site.
define('NAV_PATH', ABSPATH . '/views/_includes/nav.php');

// Caminho para a view com o rodapé básico de todas as views.
define('FOOTER_PATH', ABSPATH . '/views/_includes/footer.php');

// Tipo de mensagem para um form: erro.
define('FORM_MESSAGE_TYPE_ERROR', 1);

// Tipo de mensagem para um form: sucesso.
define('FORM_MESSAGE_TYPE_SUCCESS', 2);

// Modo debug.
define('DEBUG', false);

/*
 * Carrega o loader, que vai carregar a aplicação.
 * Não é necessário usar require_once, uma vez
 * que apenas será chamado uma vez.
 */
require ABSPATH . '/loader.php';
