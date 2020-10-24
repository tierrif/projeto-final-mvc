<?

/*
 * Controlador para o administrador do
 * site. Este controlador contem como
 * ação tudo o que pode ser gestionado
 * por um administrador. Necessita
 * estritamente de permissões admin.
 */

class ManageController extends Controller {
    public function __construct($params = []) {
        // Construtor de Controller com parâmetros da URI e título da view.
        parent::__construct($params, 'Dashboard Admin', 'management', true); // O model será alterado exceto em index()/dashboard().
        $this->addRequiredPermission('admin');
    }

    public function index() {
        // Página por defeito.
        $this->setNavPos('manage/dashboard');
        $this->dashboard();
    }

    public function dashboard() {
        // Requerir a view para este controlador.
        $this->managementView('/views/manage/dashboard-view.php');
    }

    public function associations() {
        $this->setModel('manageassociations');
        $this->getModel()->validateForm('manage/associations');
        $this->managementView('/views/manage/manage-associations-view.php', 'Gerir Associações');
    }

    public function news() {
        $this->setModel('managenews');
        $this->getModel()->validateForm('manage/news');
        $this->managementView('/views/manage/manage-news-view.php', 'Gerir Notícias');
    }

    public function eventos() {
        $this->setModel('manageeventos');
        $this->getModel()->validateForm('manage/eventos');
        $this->managementView('/views/manage/manage-eventos-view.php', 'Gerir Eventos');
    }

    public function quotas() {
        $this->setModel('managequotas');
        $this->getModel()->validateForm('manage/quotas');
        $this->managementView('/views/manage/manage-quotas-view.php', 'Gerir Quotas');
    }

    public function members() {
        $this->setModel('managemembers');
        $this->getModel()->validateForm('manage/members');
        $this->managementView('/views/manage/manage-members-view.php', 'Gerir Sócios');
    }

    public function permissions() {
        $this->setModel('managepermissions');
        $this->getModel()->validateForm('manage/permissions');
        $this->managementView('/views/manage/manage-permissions-view.php', 'Gerir Permissões');
    }

    // Excessão: Carrega barra de navegação específica a administração, assim como controla eliminação de itens.
    private function managementView($pathToView, $title = 'Dashboard Admin') {
        // Controlo de eliminação de itens.
        if (arrayValue($this->getParams(), 0)
            && arrayValue($this->getParams(), 1)
            && $this->getParams()[0] === 'delete') {
            $this->getModel()->delete($this->getParams()[1]);
        } elseif (arrayValue($this->getParams(), 0)
            && arrayValue($this->getParams(), 1)
            && $this->getParams()[0] === 'edit') {
            $this->getModel()->setFormData($this->getModel()->getById($this->getParams()[1]));
        }
        $this->setTitle($title);
        $this->view('/views/manage/admin-nav.php');
        $this->view($pathToView);
    }
}
