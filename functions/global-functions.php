<?

/*
 * Verifica se a chave $key de $array
 * existe e retorna o valor. Se não existe,
 * retorna null.
 */
function arrayValue($array, $key) {
    // Ambos os parâmetros são necessários.
    if ($array === null || $key === null) return null;
    // Verifica se a chave existe no array.
    if (isset($array[$key]) && !empty($array[$key])) {
        // Retorna o valor da chave.
        return $array[$key];
    }

    // Retorna nulo por padrão.
    return null;
}

/*
 * Mostrar informação relevante
 * ao programador durante o
 * desenvolvimento da aplicação.
 */
function debug($message) {
    // Apenas mostrar informação se estivermos em modo DEBUG.
    if (DEBUG) echo "<b>DEBUG: </b>$message<br/>";
}

/*
 * Cria uma instância de FormDataElement
 * com sintaxe mais simples.
 * $name - atributo 'name' no elemento.
 * $params - parâmetros separados por '|' (SEM ESPAÇOS).
 * Exemplo: createFormElement('nome', 'required|numeric')
 */
function createFormElement($name, $params = '') {
    $paramArray = explode('|', $params);
    return new FormDataElement($name, in_array('required', $paramArray), in_array('numeric', $paramArray));
}

/*
 * Carrega todas as classes automaticamente.
 */
function __autoload($className) {
    // Dinâmicamente carregar todos os caminhos possíveis.
    $toCheck = [
        ABSPATH . '/classes/class-' . strtolower($className) . '.php',
        ABSPATH . '/events/interface-' . strtolower($className) . '.php',
        ABSPATH . '/events/' . $className . '.php',
        ABSPATH . '/listeners/interface-' . strtolower($className) . '.php',
        ABSPATH . '/listeners/' . $className . '.php'
    ];

    // Iterar $toCheck e verificar se o ficheiro existe.
    foreach ($toCheck as $file) {
        if (!file_exists($file)) continue;
        // Existe, por isso podemos requeri-lo.
        require_once $file;
        // Já não é necessário verificar mais nada, retorna.
        return;
    }
}
