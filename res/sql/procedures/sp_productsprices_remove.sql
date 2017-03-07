CREATE PROCEDURE sp_productsprices_remove(
pidprice INT
)
BEGIN

    DELETE FROM tb_productsprices 
    WHERE idprice = pidprice;

END