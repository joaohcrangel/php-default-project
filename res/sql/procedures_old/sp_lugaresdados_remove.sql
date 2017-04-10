CREATE PROCEDURE sp_lugaresdados_remove(
pidlugar INT
)
BEGIN

	DELETE FROM tb_lugaresdados WHERE idlugar = pidlugar;

END