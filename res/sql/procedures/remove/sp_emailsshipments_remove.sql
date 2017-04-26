CREATE PROCEDURE sp_emailsshipments_remove(
pidshipment INT
)
BEGIN

    DELETE FROM tb_emailsshipments 
    WHERE idshipment = pidshipment;

END