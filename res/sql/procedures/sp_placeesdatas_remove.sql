CREATE PROCEDURE sp_placeesdatas_remove(
pidplace INT
)
BEGIN

	DELETE FROM tb_placeesdatas WHERE idplace = pidplace;

END