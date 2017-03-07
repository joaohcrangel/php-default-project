CREATE PROCEDURE sp_productstypes_remove(
pidproducttype INT
)
BEGIN

    DELETE FROM tb_productstypes 
    WHERE idproducttype = pidproducttype;

END