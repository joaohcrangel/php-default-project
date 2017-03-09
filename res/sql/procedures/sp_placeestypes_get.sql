CREATE PROCEDURE sp_placeestypes_get(
pidplacetype INT
)
BEGIN

	SELECT * FROM tb_placeestypes WHERE idplacetype = pidplacetype;

END