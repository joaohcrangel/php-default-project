CREATE PROCEDURE sp_productsdata_remove(
pidproduct INT
)
BEGIN
	
	DELETE FROM tb_productsdata WHERE idproduct = pidproduct;
    
END