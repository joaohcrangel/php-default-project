CREATE PROCEDURE sp_cartsfreights_remove(
pidcart INT
)
BEGIN

    DELETE FROM tb_cartsfreights 
    WHERE idcart = pidcart;

END