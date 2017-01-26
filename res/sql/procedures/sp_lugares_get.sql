CREATE PROCEDURE sp_lugares_get(
pidlugar INT
)
BEGIN

	SELECT * FROM tb_lugares WHERE idlugar = pidlugar;

END