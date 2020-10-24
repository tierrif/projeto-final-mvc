<?

/*
 * Esta classe abstrata deve ser herdada sempre
 * que um modelo exista meramente para fazer
 *
 * Esta classe implementa o padrão de desenho
 * do iterator, mesmo que seja um modelo, assim
 * como Factory Method, que apesar de não
 * ser como o Factory Method comum, Models ainda
 * são criados pela declaração de classes que o herdam.
 * Apenas dados que variam são usados nesta declaração,
 * e são passados pelos métodos abstratos que têm de
 * ser subscritos.
 */
abstract class DisplayModel extends Model {
    private $_i;
    private $_list;

    public function __construct($db, $params) {
        parent::__construct($db, $params);
        debug('Instanciação de DisplayModel...');
        // Inicializar a variável de contagem.
        $this->_i = 0;
        // Obter já todos os dados correspondentes ao contexto da classe-filho.
        $this->_list = $this->getAll();
    }

    public function hasNext() {
        return $this->_i < count($this->_list);
    }

    public function next() {
        // Se não estivermos na última posição, incrementa.
        if ($this->hasNext()) return $this->_list[$this->_i++];
        else return null;
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
     * por obter um dado da tabela
     * correspondente através do seu
     * ID.
     *
     * Não é obrigatório.
     */
    public function getSelectByIdQuery() { return null; }
}
