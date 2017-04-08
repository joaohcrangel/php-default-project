CREATE PROCEDURE sp_carts_get(
pidcart INT
)
BEGIN

    SELECT *    
    FROM tb_carts
    INNER JOIN tb_persons USING(idperson)
    WHERE idcart = pidcart;

END