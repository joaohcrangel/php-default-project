CREATE PROCEDURE sp_lugareshorarios_remove(
pidhorario INT
)
BEGIN

    DELETE FROM tb_lugareshorarios 
    WHERE idhorario = pidhorario;

END