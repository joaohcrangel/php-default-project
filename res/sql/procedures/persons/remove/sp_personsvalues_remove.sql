CREATE PROCEDURE sp_personsvalues_remove(
pidpersonvalue INT
)
BEGIN

    DELETE FROM tb_personsvalues 
    WHERE idpersonvalue = pidpersonvalue;

END