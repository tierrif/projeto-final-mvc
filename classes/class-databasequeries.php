<?

class DatabaseQueries {
    // Outros.
    const SELECT_LOGIN_SOCIO = 'SELECT * FROM Socio WHERE login = ';
    const UPDATE_SESSIONS_SOCIO = 'UPDATE Socio SET sessao = ';
    const SELECT_FROM_PERMISSIONS_BY_SOCIO_ID = 'SELECT * FROM Permission WHERE idSocio = ';
    const SELECT_FROM_QUOTA_BY_SOCIO_ID = 'SELECT * FROM Quota WHERE idSocio = ';

    // Admin Associação.
    const INSERT_INTO_ASSOCIACAO = 'INSERT INTO Associacao (nome, morada, telefone, numContribuinte) VALUES (?, ?, ?, ?)';
    const UPDATE_ASSOCIACAO = 'UPDATE Associacao SET nome = ?, morada = ?, telefone = ?, numContribuinte = ? WHERE idAssociacao = ?';
    const SELECT_FROM_ASSOCIACAO = 'SELECT * FROM Associacao';
    const DELETE_FROM_ASSOCIACAO = 'DELETE FROM Associacao WHERE idAssociacao = ';
    const SELECT_FROM_ASSOCIACAO_BY_ID = 'SELECT * FROM Associacao WHERE idAssociacao = ';

    // Admin Evento.
    const INSERT_INTO_EVENTO = 'INSERT INTO Evento (idAssociacao, titulo, evento, `data`) VALUES (?, ?, ?, ?)';
    const UPDATE_EVENTO = 'UPDATE Evento SET idAssociacao = ?, titulo = ?, evento = ?, `data` = ? WHERE idEvento = ?';
    const SELECT_FROM_EVENTO = 'SELECT * FROM Evento';
    const DELETE_FROM_EVENTO = 'DELETE FROM Evento WHERE idEvento = ';
    const SELECT_FROM_EVENTO_BY_ID = 'SELECT * FROM Evento WHERE idEvento = ';

    // Admin Socio.
    const INSERT_INTO_SOCIO = 'INSERT INTO Socio (nome, email, login, password, idAssociacao) VALUES (?, ?, ?, ?, ?)';
    const UPDATE_SOCIO = 'UPDATE Socio SET nome = ?, email = ?, login = ?, password = ?, idAssociacao = ? WHERE idSocio = ?';
    const SELECT_FROM_SOCIO = 'SELECT * FROM Socio';
    const DELETE_FROM_SOCIO = 'DELETE FROM Socio WHERE idSocio = ';
    const SELECT_FROM_SOCIO_BY_ID = 'SELECT * FROM Socio WHERE idSocio = ';

    // Admin Permission.
    const INSERT_INTO_PERMISSION = 'INSERT INTO Permission (nome, idSocio) VALUES (?, ?)';
    const UPDATE_PERMISSION = 'UPDATE Socio SET nome = ?, idSocio = ? WHERE idPermission = ?';
    const SELECT_FROM_PERMISSION = 'SELECT * FROM Permission';
    const DELETE_FROM_PERMISSION = 'DELETE FROM Permission WHERE idPermission = ';
    const SELECT_FROM_PERMISSION_BY_ID = 'SELECT * FROM Permission WHERE idPermission = ';

    // Admin Notícia.
    const INSERT_INTO_NOTICIA = 'INSERT INTO Noticia (titulo, noticia, imagem, idAssociacao) VALUES (?, ?, ?, ?)';
    const UPDATE_NOTICIA = 'UPDATE Noticia SET titulo = ?, noticia = ?, imagem = ?, idAssociacao = ? WHERE idNoticia = ?';
    const SELECT_FROM_NOTICIA = 'SELECT * FROM Noticia';
    const DELETE_FROM_NOTICIA = 'DELETE FROM Noticia WHERE idNoticia = ';
    const SELECT_FROM_NOTICIA_BY_ID = 'SELECT * FROM Noticia WHERE idNoticia = ';

    // Admin Quota.
    const INSERT_INTO_QUOTA = 'INSERT INTO Quota (idSocio, dataComeco, dataTermino, preco) VALUES (?, ?, ?, ?)';
    const UPDATE_QUOTA = 'UPDATE Quota SET idSocio = ?, dataComeco = ?, dataTermino = ?, preco = ? WHERE idQuota = ?';
    const SELECT_FROM_QUOTA = 'SELECT * FROM Quota';
    const DELETE_FROM_QUOTA = 'DELETE FROM Quota WHERE idQuota = ';
    const SELECT_FROM_QUOTA_BY_ID = 'SELECT * FROM Quota WHERE idQuota = ';

    // Inscrições.
    const INSERT_INTO_INSCRICAO = 'INSERT INTO Inscricao (idSocio, idEvento) VALUES (?, ?)';
    const DELETE_FROM_INSCRICAO = 'DELETE FROM Inscricao WHERE idEvento = ';
    const SELECT_FROM_INSCRICAO = 'SELECT * FROM Inscricao WHERE idSocio = ';
}
