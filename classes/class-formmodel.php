<?

/*
 * Esta classe abstrata deve ser herdada sempre
 * que um modelo tenha gestão de formulários.
 */
abstract class FormModel extends Model {
    private $_formData; // string[].
    private $_formMessage; // string.
    private $_formMessageType; // (FORM_MESSAGE_TYPE_SUCCESS | FORM_MESSAGE_TYPE_ERROR): int.

    public function __construct($db, $params) {
        parent::__construct($db, $params);
        $this->_formData = $_POST;
    }

    /*
     * Validar os dados do form.
     */
    public function validateForm($redirectTo = '') {
        debug('A iniciar validação...');
        // Obter todos os elementos do formulário.
        $elements = $this->getFormDataElements();
        // Iterar estes elementos.
        foreach ($elements as $element) {
            debug('Elemento ' . $element->getName() . ' a ser validado com valor ' . $this->fetchData($element->getName()));
            $content = $this->fetchData($element->getName());
            if ($element->isNumeric() && !is_numeric($content) && $content) {
                debug("{$element->getName()} tem de ser numérico!");
                // Este elemento deve ser numérico.
                $this->setFormMessage("{$element->getName()} tem de ser numérico!", FORM_MESSAGE_TYPE_ERROR);
                return;
            }
            if ($element->isRequired() && !$content) {
                debug("{$element->getName()} é obrigatório!");
                // Este elemento deve ter um valor.
                $this->setFormMessage("{$element->getName()} é obrigatório!", FORM_MESSAGE_TYPE_ERROR);
                return;
            }
            if (!$this->customVerification($element, $content)) return;
        }

        // Agora que o form foi validado com sucesso, lógica é da responsabilidade do modelo.
        $this->onFormValidated();

        debug('Redirecting to: ' . (!$redirectTo ? '' : $redirectTo));
        // Redireciona para o perfil se redirectTo é null.
        header('Location: ' . HOME_URI . '/' . (!$redirectTo ? '' : $redirectTo));
    }

    public function getAll() {
        // Query à base de dados.
        $query = $this->getDb()->getPDO()->query($this->getSelectAllQuery());
        // Verificar se falhou.
        if (!$query) {
            debug('Query falhou: ' . $this->getSelectAllQuery());
            return null;
        }

        $toReturn = []; // Associacao[].
        foreach ($query->fetchAll() as $data) {
            $toReturn[] = $this->onElementIteration($data);
        }

        return $toReturn;
    }

    public function delete($id) {
        // Executa onDelete no caso de haver algo a fazer neste evento.
        $this->onDelete($id);
        // Query à base de dados.
        $query = $this->getDb()->getPDO()->query($this->getDeleteQuery() . $id);
        // Verificar se falhou.
        if (!$query) debug('Query falhou: ' . $this->getDeleteQuery());
    }

    public function getById($id) {
        // Query à base de dados.
        $query = $this->getDb()->getPDO()->query($this->getSelectByIdQuery() . $id);
        // Verificar se falhou.
        if (!$query) {
            debug('Query falhou: ' . $this->getSelectAllQuery());
            return null;
        }

        return $query->fetch();
    }

    /*
     * Busca dos dados do form com a chave
     * $data em _formData.
     */
    public function fetchData($data) {
        return arrayValue($this->getFormData(), $data);
    }

    public function getFormData() {
        return $this->_formData;
    }

    public function setFormData($newData) {
        $this->_formData = $newData;
    }

    public function getFormMessage() {
        return $this->_formMessage;
    }

    protected function setFormMessage($message = '', $messageType = FORM_MESSAGE_TYPE_SUCCESS) {
        $this->_formMessage = $message;
        $this->_formMessageType = $messageType;
    }

    public function getFormMessageType() {
        return $this->_formMessageType;
    }

    /*
     * Deverá ser retornado um array de FormDataElement
     * para verificar todos estes elementos.
     */
    public abstract function getFormDataElements();

    /*
     * Validação do elemento irregular.
     * Retornar true se o elemento está validado, false
     * se não.
     *
     * SE NÃO HOUVER VALIDAÇÃO NECESSÁRIA, SIMPLESMENTE
     * RETORNAR TRUE!
     *
     * Não é obrigatório.
     */
    public function customVerification($element, $value) { return true; }

    /*
     * Lógica a processar quando o form foi validado
     * com sucesso. Executa exatamente antes de ser
     * feito redirecionamento.
     *
     * Não é obrigatório.
     */
    public function onFormValidated() {}

    /*
     * Retornar a query responsável
     * por selecionar todos os dados
     * da tabela correspondente.
     *
     * Não é obrigatório.
     */
    public function getSelectAllQuery() { return null; }

    /*
     * Retornar a instância da classe
     * que corresponde ao contexto deste
     * modelo.
     *
     * Não é obrigatório.
     */
    public function onElementIteration($data) { return null; }

    /*
     * Retornar a query responsável
     * por eliminar um dado da
     * tabela correspondente.
     *
     * Não é obrigatório.
     */
    public function getDeleteQuery() { return null; }

    /*
     * Retornar a query responsável
     * por obter um dado da tabela
     * correspondente através do seu
     * ID.
     *
     * Não é obrigatório.
     */
    public function getSelectByIdQuery() { return null; }

    /*
     * Executa após eliminação de elemento
     * da base de dados.
     *
     * Não é obrigatório.
     */
    public function onDelete($id) {}
}
