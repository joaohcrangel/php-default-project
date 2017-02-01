CREATE PROCEDURE sp_enderecostipos_get(
pidenderecotipo INT
)
BEGIN

      SELECT *    
    FROM tb_enderecostipos    
    WHERE idenderecostipos = pidenderecostipo;


END
