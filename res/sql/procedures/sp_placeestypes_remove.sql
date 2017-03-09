CREATE PROCEDURE sp_placeestypes_remove(
pidplacetype INT
)
BEGIN

	DELETE FROM tb_placeestypes WHERE idplacetype = pidplacetype;

END