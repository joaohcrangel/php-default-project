CREATE PROCEDURE sp_enderecosfromlugar_list(
pidlugar INT
)
BEGIN

	SELECT a.*, c.deslugar FROM tb_enderecos a
		INNER JOIN tb_lugaresenderecos b ON a.idendereco = b.idendereco
        INNER JOIN tb_lugares c ON c.idlugar = b.idlugar
	WHERE c.idlugar = pidlugar ORDER BY a.desendereco;

END