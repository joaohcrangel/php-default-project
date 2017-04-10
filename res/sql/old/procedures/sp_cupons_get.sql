CREATE PROCEDURE sp_cupons_get(
pidcupom INT
)
BEGIN

    SELECT *    
    FROM tb_cupons    
    WHERE idcupom = pidcupom;

END