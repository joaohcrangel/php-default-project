CREATE PROCEDURE sp_placestypes_get(
pidplacetype INT
)
BEGIN

	SELECT * FROM tb_placestypes WHERE idplacetype = pidplacetype;

END