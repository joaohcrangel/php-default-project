CREATE PROCEDURE sp_carts_remove(
pidcart INT
)
BEGIN

    DELETE FROM tb_carts 
    WHERE idcart = pidcart;

END