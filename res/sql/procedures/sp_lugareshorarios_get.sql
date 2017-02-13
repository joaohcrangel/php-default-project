CREATE PROCEDURE sp_lugareshorarios_get(
pidhorario INT
)
BEGIN

    SELECT *    
    FROM tb_lugareshorarios    
    WHERE idhorario = pidhorario;

END