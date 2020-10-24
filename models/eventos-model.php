<?

class EventosModel extends DisplayModel {
    public function onElementIteration($data) {
        return new Evento($data['idEvento'], $data['titulo'], $data['evento'], $data['idAssociacao'], $data['data']);
    }

    public function getSelectAllQuery() {
        return DatabaseQueries::SELECT_FROM_EVENTO;
    }

    public function getSelectByIdQuery() {
        return DatabaseQueries::SELECT_FROM_EVENTO_BY_ID;
    }
}
