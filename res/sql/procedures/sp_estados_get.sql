CREATE PROCEDURE sp_estados_get(
pidestado INT
)
BEGIN

    SELECT *    
    FROM tb_estados a
    INNER JOIN tb_paises b USING(idpais) 
    WHERE a.idestado = pidestado;

END