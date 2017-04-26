CREATE PROCEDURE sp_placestypes_remove(
pidplacetype INT
)
BEGIN

	DELETE FROM tb_placestypes WHERE idplacetype = pidplacetype;

END