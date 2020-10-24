<?

/*
 * Fábrica de modelos.
 * Em vez de usar um switch/vários if's,
 * tornar a instanciação de todos os modelos
 * dinâmica.
 */
class ModelFactory {
    public function getModel($class, $params, $baseName = null) {
        if (!$baseName) {
            // Obter o nome do ficheiro.
            $fileName = str_replace('controller', '-model', strtolower($class));
        } else $fileName = $baseName . '-model'; // Adicionar -model ao fim do nome para incluir o ficheiro em si.
        // Mostrar o nome do modelo durante desenvolvimento.
        debug($fileName);
        // Se o ficheiro não existir, retorna null, porque o modelo não existe.
        if (!file_exists(ABSPATH . "/models/$fileName.php")) return null;
        // Requerir o modelo para requerir a classe.
        require_once ABSPATH . "/models/$fileName.php";
        if (!$baseName) {
            // Obter o nome da classe.
            $className = str_replace('Controller', 'Model', $class);
        } else $className = ucfirst($baseName) . 'Model'; // ucfirst() transforma o primeiro carater a maiúsculo. https://www.php.net/manual/en/function.ucfirst.php
        // Retorna a instância do modelo.
        return new $className(SystemDB::getInstance(), $params);
    }
}
