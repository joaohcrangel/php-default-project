CREATE PROCEDURE sp_personsdevices_get(
piddevice INT
)
BEGIN

    SELECT *    
    FROM tb_personsdevices    
    WHERE iddevice = piddevice;

END