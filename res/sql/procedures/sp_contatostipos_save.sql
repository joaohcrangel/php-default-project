CREATE PROCEDURE sp_contatostipos_save(
pidcontatotipo INT,
pdescontatotipo VARCHAR(64)
)
BEGIN

	IF pidcontatotipo = 0 OR pidcontatotipo IS NULL THEN

		INSERT INTO tb_contatostipos (descontatotipo)
		VALUES(pdescontatotipo);

		SET pdescontatotipo = LAST_INSERT_ID();

	ELSE

		UPDATE tb_contatostipos
		SET descontatotipo = pdescontatotipo
		WHERE idcontatotipo = pidcontatotipo;

	END IF;

	CALL sp_contatostipos_get(pidcontatotipo);

END