CREATE PROCEDURE sp_cuponstipos_get(
pidcupomtipo INT
)
BEGIN

    SELECT *    
    FROM tb_cuponstipos    
    WHERE idcupomtipo = pidcupomtipo;

END