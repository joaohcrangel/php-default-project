CREATE PROCEDURE sp_personsvalues_get(
pidpersonvalue INT
)
BEGIN

	SELECT a.*, b.desperson, c.desfield FROM tb_personsvalues a
		INNER JOIN tb_persons b ON a.idperson = b.idperson
        INNER JOIN tb_personsvaluesfields c ON a.idfield = c.idfield
	WHERE a.idpersonvalue = pidpersonvalue;

END