CREATE PROCEDURE sp_sitescontactsfromperson_list(
pidperson INT
)
BEGIN

	SELECT * FROM tb_sitescontacts WHERE idperson = pidperson;

END