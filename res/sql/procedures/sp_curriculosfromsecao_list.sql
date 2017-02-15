CREATE PROCEDURE sp_curriculosfromsecao_list(
pidsecao INT
)
BEGIN

    SELECT a.*, b.dessecao, b.nrordem, c.descurso, c.destitulo, c.vlcargahoraria, c.nraulas, c.nrexercicios,
        c.desdescricao, c.inremovido
    FROM tb_cursoscurriculos a
        INNER JOIN tb_cursossecoes b ON a.idsecao = b.idsecao
        INNER JOIN tb_cursos c ON b.idcurso = c.idcurso
    WHERE a.idsecao = pidsecao;

END