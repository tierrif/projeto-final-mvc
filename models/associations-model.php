<?

class AssociationsModel extends DisplayModel {
    public function onElementIteration($data) {
        return new Associacao($data['idAssociacao'], $data['nome'], $data['morada'], $data['telefone'], $data['numContribuinte']);
    }

    public function getSelectAllQuery() {
        return DatabaseQueries::SELECT_FROM_ASSOCIACAO;
    }

    public function getSelectByIdQuery() {
        return DatabaseQueries::SELECT_FROM_ASSOCIACAO_BY_ID;
    }
}
