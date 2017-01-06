CREATE PROCEDURE sp_cartoesdecreditos_remove(
pidcartao INT
)
BEGIN
	
	DELETE FROM tb_cartoesdecreditos WHERE idcartao = pidcartao;

END