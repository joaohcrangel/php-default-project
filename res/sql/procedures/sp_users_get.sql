CREATE PROCEDURE sp_users_get(
piduser INT
)
BEGIN

    SELECT
	a.iduser, a.idperson, a.desuser, a.despassword, a.inblocked, a.dtregister, a.idusertype,
	GROUP_CONCAT(b.idpermission) AS despermissions
	FROM tb_users a
	LEFT JOIN tb_permissionsusers b ON a.iduser = b.iduser
	WHERE a.iduser = piduser
	GROUP BY a.iduser, a.idperson, a.desuser, a.despassword, a.inblocked, a.dtregister, a.idusertype;

END