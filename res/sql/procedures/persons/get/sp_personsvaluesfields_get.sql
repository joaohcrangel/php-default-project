CREATE PROCEDURE sp_personsvaluesfields_get(
pidfield INT
)
BEGIN

    SELECT *    
    FROM tb_personsvaluesfields    
    WHERE idfield = pidfield;

END