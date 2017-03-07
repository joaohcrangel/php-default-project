CREATE PROCEDURE sp_pessoasarquivos_save (
pidpessoa INT,
pidarquivo INT
)
BEGIN

	DELETE FROM tb_pessoasarquivos WHERE idpessoa = pidpessoa AND idarquivo = pidarquivo;
    INSERT INTO tb_pessoasarquivos (idpessoa, idarquivo)
    VALUES(pidpessoa, pidarquivo);

END
