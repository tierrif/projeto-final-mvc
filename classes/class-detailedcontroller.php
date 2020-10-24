<?

abstract class DetailedController extends Controller {
    public function details() {
        // Se não houver parâmetro de ID, redireciona.
        if (!arrayValue($this->getParams(), 0)) {
            header('Location: ' . $this->getRedirect());
            return;
        }

        $obj = $this->getModel()->getById($this->getParams()[0]);
        if (!$obj) {
            // Se não existe.
            $this->view('/views/_includes/404.php');
            return;
        }

        /*
         * Como o PHP é de tipagem dinâmica, uma
         * das suas funcionalidades é tornar de
         * um objeto simples em algo iterável.
         * Em grande parte das linguagens dinâmicas (JS, PHP),
         * objetos são um array associativo.
         *
         * https://www.php.net/manual/en/language.oop5.iterations.php
         */
        foreach ($obj as $key => $value) {
            // Se for uma chave permitida...
            if (in_array($key, $this->getAllowedKeys(), true)) {
                $this->setData($this->getDisplayNames()[$key], $value);
            }
        }

        $this->view('/views/details/details-view.php', true);
    }

    public function loadExtraViews() {
        // Views extra a carregar, se aplicável.
        foreach ($this->extraViewsToLoad() as $view) $this->view($view);
    }

    // Na iteração da classe, apenas aceita as chaves retornadas.
    protected abstract function getAllowedKeys();

    // Retornar array associativo com a chave como nome do atributo e valor como texto tratado que o represente.
    protected abstract function getDisplayNames();

    // Se não houverem parâmetros, redirecionar para a URI retornada.
    protected abstract function getRedirect();

    // Não obrigatório. Views extras a carregar se aplicável.
    protected function extraViewsToLoad() { return []; }
}
