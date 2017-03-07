CREATE PROCEDURE sp_personsdevices_remove(
piddevice INT
)
BEGIN

    DELETE FROM tb_personsdevices 
    WHERE iddevice = piddevice;

END