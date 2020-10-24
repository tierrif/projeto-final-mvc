window.onload = function () {
    // querySelectorAll() é equivalente a um seletor jQuery em JavaScript puro (retorna conjunto de nós HTML).
    const liList = document.querySelectorAll('.menu ul li');
    // Iterar os nós encontrados.
    for (var i = 0; i < liList.length; i++) {
        // Devemos criar uma constante li e não usar 'i' na função onclick pois 'i' alterará valor.
        const li = liList[i];
        // Registar o listener de click.
        li.onclick = function () {
            // Redirecionar.
            window.location.href = li.getElementsByTagName('a')[0].href;
        }
    }
}
