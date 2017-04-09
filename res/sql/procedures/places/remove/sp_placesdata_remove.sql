CREATE PROCEDURE sp_placesdata_remove(
pidplace INT
)
BEGIN

	DELETE FROM tb_placesdata WHERE idplace = pidplace;

END