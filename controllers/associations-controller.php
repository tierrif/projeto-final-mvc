<?

/*
 * Controlador para as associações.
 */

class AssociationsController extends DetailedController {
    public function __construct($params = []) {
        // Construtor de Controller com parâmetros da URI e título da view.
        parent::__construct($params, 'Associações');
    }

    public function index() {
        // Requerir a view para este controlador.
        $this->view('/views/associations/associations-view.php', true);
    }

    protected function getAllowedKeys() {
        return ['nome', 'morada', 'telefone'];
    }

    protected function getDisplayNames() {
        return [
            'nome' => 'Nome da associação',
            'morada' => 'Morada da sede',
            'telefone' => 'Número de telefone (fixo)'
        ];
    }

    protected function getRedirect() {
        return HOME_URI . '/associations';
    }
}
