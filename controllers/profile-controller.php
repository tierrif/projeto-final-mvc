<?

/*
 * Controlador para o perfil.
 */

class ProfileController extends Controller {
    private $_id; // int.

    public function __construct($params = []) {
        // Construtor de Controller com parâmetros da URI e título da view. modelBaseName setado porque o nome do modelo é diferente.
        parent::__construct(
            $params,
            'Perfil: ' . AuthManager::getInstance()->getUser(),
            'members',
            true
        );
        $this->_id = AuthManager::getInstance()->getUserIdByUsername(AuthManager::getInstance()->getUser());
    }

    public function index() {
        // Verificar pagamentos requeridos e disparar evento se existir (Observer).
        $this->getModel()->verifyQuotaPayment($this->_id);
        // Adicionar notificações aos dados adicionais do pedido.
        $this->setData('notifs', QuotaHandler::getInstance()->getNotificationsFrom($this->_id));
        // Requerir as views para este controlador.
        $this->view('/views/profile/profile-nav.php');
        $this->view('/views/profile/profile-view.php');
    }

    public function quotas() {
        $this->view('/views/profile/profile-nav.php');
        $this->view('/views/profile/profile-quotas-view.php');
    }

    public function subscriptions() {
        $this->setData('subscriptions', $this->getModel()->getSubscriptions($this->_id));
        $this->view('/views/profile/profile-nav.php');
        $this->view('/views/profile/profile-subscriptions-view.php');
    }

    protected function getId() {
        return $this->_id;
    }
}
