CREATE PROCEDURE sp_projectsstatus_get(
pidstatus INT
)
BEGIN

    SELECT *    
    FROM tb_projectsstatus    
    WHERE idstatus = pidstatus;

END;