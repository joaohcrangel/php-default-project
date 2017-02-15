CREATE PROCEDURE sp_arquivos_remove(
pidarquivo INT
)
BEGIN

    DELETE FROM tb_arquivos 
    WHERE idarquivo = pidarquivo;

END