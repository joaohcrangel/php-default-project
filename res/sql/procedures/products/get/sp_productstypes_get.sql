CREATE PROCEDURE sp_productstypes_get(
pidproducttype INT
)
BEGIN

    SELECT *    
    FROM tb_productstypes    
    WHERE idproducttype = pidproducttype;

END