CREATE PROCEDURE sp_carrinhoscupons_get(
pidcarrinho INT,
pidcupom INT
)
BEGIN

    SELECT *    
    FROM tb_carrinhoscupons    
    WHERE idcarrinho = pidcarrinho AND idcupom = pidcupom;

END