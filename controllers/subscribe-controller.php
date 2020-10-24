<?

class SubscribeController extends Controller {
    public function index() {
        header('Location: ' . HOME_URI);
    }

    public function create() {
        if (!arrayValue($this->getParams(), 0)) {
            header('Location: ' . HOME_URI);
            return;
        }
        $this->getModel()->createSubscription($this->getParams()[0]);
        // Redirecionar: este controlador não tem view.
        header('Location: ' . HOME_URI . '/profile/subscriptions');
    }

    public function delete() {
        if (!arrayValue($this->getParams(), 0)) {
            header('Location: ' . HOME_URI);
            return;
        }
        $this->getModel()->deleteSubscription($this->getParams()[0]);
        // Redirecionar: este controlador não tem view.
        header('Location: ' . HOME_URI . '/profile/subscriptions');
    }
}
