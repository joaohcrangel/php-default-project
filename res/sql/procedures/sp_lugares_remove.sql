CREATE PROCEDURE sp_lugares_remove(
pidlugar INT
)
BEGIN

	DELETE FROM tb_lugares WHERE idlugar = pidlugar;

END