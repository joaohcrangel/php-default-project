CREATE PROCEDURE sp_personsvaluesfields_remove(
pidfield INT
)
BEGIN

    DELETE FROM tb_personsvaluesfields 
    WHERE idfield = pidfield;

END