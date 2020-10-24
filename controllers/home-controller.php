<?

/*
 * Controlador para a página principal
 * do site.
 */

class HomeController extends Controller {
    public function __construct($params = []) {
        // Construtor de Controller com parâmetros da URI e título da view.
        parent::__construct($params, 'Homepage');
    }

    public function index() {
        // Requerir a view para este controlador.
        $this->view('/views/home/home-view.php', true);
    }
}
