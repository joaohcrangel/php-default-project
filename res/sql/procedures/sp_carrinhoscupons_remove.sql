CREATE PROCEDURE sp_carrinhoscupons_remove(
pidcarrinho INT,
pidcupom INT
)
BEGIN

    DELETE FROM tb_carrinhoscupons 
    WHERE idcarrinho = pidcarrinho AND idcupom = pidcupom;

END