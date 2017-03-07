CREATE PROCEDURE sp_estados_remove(
pidestado INT
)
BEGIN

    DELETE FROM tb_estados 
    WHERE idestado = pidestado;

END