CREATE PROCEDURE sp_cuponstipos_remove(
pidcupomtipo INT
)
BEGIN

    DELETE FROM tb_cuponstipos 
    WHERE idcupomtipo = pidcupomtipo;

END