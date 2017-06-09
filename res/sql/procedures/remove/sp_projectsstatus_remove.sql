CREATE PROCEDURE sp_projectsstatus_remove(
pidstatus INT
)
BEGIN

    DELETE FROM tb_projectsstatus 
    WHERE idstatus = pidstatus;

END;