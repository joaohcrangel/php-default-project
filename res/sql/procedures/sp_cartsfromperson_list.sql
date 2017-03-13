CREATE PROCEDURE sp_cartsfromperson_list(
pidperson INT
)
BEGIN

	SELECT * FROM tb_carts WHERE idperson = pidperson;

END