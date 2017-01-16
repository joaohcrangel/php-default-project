CREATE PROCEDURE sp_historicostipos_remove (
pidhistoricotipo INT
)
BEGIN

	DELETE FROM tb_historicostipos WHERE idhistoricotipo = pidhistoricotipo;

END;