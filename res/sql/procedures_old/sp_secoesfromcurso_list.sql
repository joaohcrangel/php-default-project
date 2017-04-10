CREATE PROCEDURE sp_secoesfromcurso_list(
pidcurso INT
)
BEGIN

    SELECT * FROM tb_cursossecoes
    WHERE idcurso = pidcurso ORDER BY nrordem;

END