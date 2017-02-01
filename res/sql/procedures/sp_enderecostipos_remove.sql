CREATE PROCEDURE sp_enderecostipos_remove(
pidenderecotipo INT
)
BEGIN

     DELETE FROM tb_enderecostipos 
    WHERE idenderecotipo = pidenderecotipo;

END
