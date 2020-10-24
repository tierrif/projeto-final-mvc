<?

/*
 * Controlador para as notícias.
 */

class NewsController extends DetailedController {
    public function __construct($params = []) {
        // Construtor de Controller com parâmetros da URI e título da view.
        parent::__construct($params, 'Notícias');
    }

    public function index() {
        // Requerir a view para este controlador.
        $this->view('/views/news/news-view.php', true);
    }

    protected function getAllowedKeys() {
        return ['titulo', 'noticia'];
    }

    protected function getDisplayNames() {
        return [
            'titulo' => 'Título do artigo',
            'noticia' => 'Notícia'
        ];
    }

    protected function getRedirect() {
        return HOME_URI . '/news';
    }

    // Imagem da notícia.
    protected function extraViewsToLoad() {
        return ['/views/news/image.php'];
    }
}
