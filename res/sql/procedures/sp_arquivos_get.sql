CREATE PROCEDURE sp_arquivos_get(
pidarquivo INT
)
BEGIN

    SELECT *    
    FROM tb_arquivos    
    WHERE idarquivo = pidarquivo;

END