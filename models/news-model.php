<?

class NewsModel extends DisplayModel {
    public function onElementIteration($data) {
        return new Noticia($data['idNoticia'], $data['titulo'], $data['noticia'], new Imagem($data['imagem'], UP_ABSPATH . '/' . $data['imagem']), $data['idAssociacao']);
    }

    public function getSelectAllQuery() {
        return DatabaseQueries::SELECT_FROM_NOTICIA;
    }

    public function getSelectByIdQuery() {
        return DatabaseQueries::SELECT_FROM_NOTICIA_BY_ID;
    }

    /*
     * Apenas pode ser chamado em controlador
     * de detalhes. Obtém ID da notícia
     * pelo URL.
     */
    public function getCurrentImage() {
        return arrayValue($this->getById(arrayValue($this->getParams(), 0)), 'imagem');
    }
}
