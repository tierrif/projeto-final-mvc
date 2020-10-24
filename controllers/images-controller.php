<?

/*
 * Controlador para o perfil.
 */

class ImagesController extends Controller {
    public function __construct($params = []) {
        // Construtor de Controller com parâmetros da URI e título da view. modelBaseName setado porque o nome do modelo é diferente.
        parent::__construct(
            $params,
            DEFAULT_TITLE,
            'news'
        );
    }

    public function index() {
        // Página por defeito da galeria.
        $page = 0;
        // Página pedida no URL.
        if (arrayValue($this->getParams(), 0)) $page = $this->getParams()[0];
        // Obter todas as notícias.
        $news = $this->getModel()->getAll();
        // Obter a imagem no resultado $page.
        $this->setData('img', arrayValue($news, $page)->getImagem()->getNome());
        // Se não existir...
        if (!$this->getData('img')) {
            $this->view('/views/_includes/404.php');
            return;
        }
        // Adicionar o resto do caminho, agora que sabemos que existe.
        $this->setData('img', HOME_URI . '/views/_uploads/' . $this->getData('img'));
        // Dar o número máximo da página.
        $this->setData('lastPage', count($news));
        // Carregar a view.
        $this->view('/views/images/images-view.php', true);
    }
}
