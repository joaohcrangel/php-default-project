CREATE PROCEDURE sp_historicostipos_save (
pidhistoricotipo INT,
pdeshistoricotipo VARCHAR(32)
)
BEGIN

	IF pidhistoricotipo IS NULL OR pidhistoricotipo = 0 THEN

		INSERT INTO tb_historicostipos (deshistoricotipo)
		VALUES(pdeshistoricotipo);

		SET pidhistoricotipo = LAST_INSERT_ID();

	ELSE

		UPDATE tb_historicostipos
		SET deshistoricotipo = pdeshistoricotipo
		WHERE idhistoricotipo = pidhistoricotipo;

	END IF;

	CALL sp_historicostipos_get(pidhistoricotipo);
	
END