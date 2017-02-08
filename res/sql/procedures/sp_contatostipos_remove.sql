CREATE PROCEDURE sp_contatostipos_remove(
pidcontatotipo INT
)
BEGIN

	DELETE
	FROM tb_contatostipos
	WHERE idcontatotipo = pidcontatotipo;

END