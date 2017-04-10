CREATE PROCEDURE sp_cupons_remove(
pidcupom INT
)
BEGIN

    DELETE FROM tb_cupons 
    WHERE idcupom = pidcupom;

END