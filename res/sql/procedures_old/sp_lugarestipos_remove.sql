CREATE PROCEDURE sp_lugarestipos_remove(
pidlugartipo INT
)
BEGIN

	DELETE FROM tb_lugarestipos WHERE idlugartipo = pidlugartipo;

END