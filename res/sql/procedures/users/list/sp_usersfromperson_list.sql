CREATE PROCEDURE sp_usersfromperson_list(
pidperson INT
)
BEGIN

	SELECT a.*, b.desperson, b.despersontype, c.* FROM tb_users a
		INNER JOIN tb_personsdata b ON a.idperson = b.idperson
        INNER JOIN tb_userstypes c ON a.idusertype = c.idusertype
	WHERE a.idperson = pidperson;

END