CREATE PROCEDURE sp_emailsshipments_get(
pidshipment INT
)
BEGIN

    SELECT *    
    FROM tb_emailsshipments    
    WHERE idshipment = pidshipment;

END