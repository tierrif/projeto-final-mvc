<?

class LoginModel extends FormModel {
    public function __construct($db, $params) {
        parent::__construct($db, $params);
    }

    public function getFormDataElements() {
        return [
            createFormElement('username', 'required'),
            createFormElement('password', 'required')
        ];
    }

    public function customVerification($element, $value) {
        if ($element->getName() === 'username' && !preg_match_all('/^\w+$/', $value)) {
            debug('preg_match_all(\'/^\w+$/\', $username == false');
            $this->setFormMessage('Um username apenas pode ter dígitos, letras ou underscores.', FORM_MESSAGE_TYPE_ERROR);
            return false;
        } elseif ($element->getName() === 'password'
            && !AuthManager::getInstance()->login($this->fetchData('username'), $value)) {
            debug('Login incorreto.');
            $this->setFormMessage('Username ou palavra passe incorreto(s).', FORM_MESSAGE_TYPE_ERROR);
            return false;
        }

        return true;
    }
}
