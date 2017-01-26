CREATE PROCEDURE sp_lugarestipos_get(
pidlugartipo INT
)
BEGIN

	SELECT * FROM tb_lugarestipos WHERE idlugartipo = pidlugartipo;

END