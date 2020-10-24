<?

/*
 * Representa cada elemento de um form e
 * mantém guardada alguma da informação
 * não declarada em HTML (ou não aplicável
 * no sistema do PHP), tais como _required
 * e _numeric, que, respetivamente, não é
 * suportado nativamente por HTML, e apenas
 * é suportado a partir do HTML 5, que terá
 * problemas de compatibilidade.
 *
 * Por esta razão, estes dados serão guardados
 * em objetos para cada elemento. Para facilitar
 * a instanciação desta classe, poderá ser usado o
 * ajudante para a criação de uma instância:
 * createFormElement(string)
 */
class FormDataElement {
    private $_name; // string.
    private $_required; // bool.
    private $_numeric; // bool.

    public function __construct($name, $required = false, $numeric = false) {
        $this->_name = $name;
        $this->_required = $required;
        $this->_numeric = $numeric;
    }

    public function getName() {
        return $this->_name;
    }

    public function isRequired() {
        return $this->_required;
    }

    public function isNumeric() {
        return $this->_numeric;
    }
}
