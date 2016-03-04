CREATE PROCEDURE sp_contatostipos_list()
BEGIN

	SELECT * 
	FROM tb_contatostipos
	ORDER BY descontatotipo;

END