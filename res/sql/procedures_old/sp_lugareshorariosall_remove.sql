CREATE PROCEDURE sp_lugareshorariosall_remove(
pidlugar INT
)
BEGIN

	DELETE FROM tb_lugareshorarios
    WHERE idlugar = pidlugar;

END