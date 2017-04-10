CREATE PROCEDURE sp_arquivosfromlugar_list(
pidlugar INT
)
BEGIN

	SELECT a.*, b.deslugar FROM tb_arquivos a
		INNER JOIN tb_lugaresarquivos c ON a.idarquivo = c.idarquivo
        INNER JOIN tb_lugares b ON c.idlugar = b.idlugar
	WHERE b.idlugar = pidlugar;

END