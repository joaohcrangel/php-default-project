CREATE PROCEDURE sp_estados_get(
pidestado INT
)
BEGIN

    SELECT *    
    FROM tb_estados    
    WHERE idestado = pidestado;

END