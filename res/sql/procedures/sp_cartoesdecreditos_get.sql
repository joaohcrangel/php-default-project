CREATE PROCEDURE sp_cartoesdecreditos_get(
pidcartao INT
)
BEGIN
	
	SELECT * FROM tb_cartoesdecreditos a INNER JOIN tb_pessoas b USING(idpessoa)
    WHERE idcartao = pidcartao;

END