<?

class Model {
    private $_db; // SystemDB.
    private $_params; // string[].

    public function __construct($db, $params) {
        $this->_db = $db;
        $this->_params = $params;
    }
    
    public function invertDate($date = null) {
        // Onde a data será invertida.
        $newDate = '';

        // Se não for passada data.
        if (!$date) return null;

        // Explode a data por -, /, : ou espaço.
        $date = preg_split('/-|\/|\s|:/', $date);

        // Remove os espaços no início e no fim dos valores.
        $date = array_map('trim', $date);

        // Cria a data invertida.
        $newDate .= arrayValue($date, 2) . '-';
        $newDate .= arrayValue($date, 1) . '-';
        $newDate .= arrayValue($date, 0);

        // Configura a hora.
        if (arrayValue($date, 3)) {
            $newDate .= ' ' . arrayValue($date, 3);
        }

        // Configura os minutos.
        if (arrayValue($date, 4)) {
            $newDate .= ':' . arrayValue($date, 4);
        }

        // Configura os segundos.
        if (arrayValue($date, 5)) {
            $newDate .= ':' . arrayValue($date, 5);
        }

        // Retorna a nova data.
        return $newDate;
    }

    public function getDb() {
        return $this->_db;
    }

    public function getParams() {
        return $this->_params;
    }
}
