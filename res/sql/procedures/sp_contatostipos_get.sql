CREATE PROCEDURE sp_contatostipos_get(
pidcontatotipo INT
)
BEGIN

	SELECT * 
	FROM tb_contatostipos
	WHERE idcontatotipo = pidcontatotipo;

END