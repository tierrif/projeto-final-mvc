<?

/*
 * Controlador para os eventos.
 */

class EventosController extends DetailedController {
    public function __construct($params = []) {
        // Construtor de Controller com parâmetros da URI e título da view.
        parent::__construct($params, 'Eventos');
    }

    public function index() {
        // Requerir a view para este controlador.
        $this->view('/views/eventos/eventos-view.php', true);
    }


    protected function getAllowedKeys() {
        return ['titulo', 'evento', 'data'];
    }

    protected function getDisplayNames() {
        return [
            'titulo' => 'Título',
            'evento' => 'Detalhes',
            'data' => 'Data do evento'
        ];
    }

    protected function getRedirect() {
        return HOME_URI . '/eventos';
    }

    // View simples apenas com um botão para inscrever-se.
    protected function extraViewsToLoad() {
        return ['/views/eventos/inscricao.php'];
    }
}
