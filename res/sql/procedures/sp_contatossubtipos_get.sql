CREATE PROCEDURE sp_contatossubtipos_get(
pidcontatosubtipo INT
)
BEGIN

    SELECT *    
    FROM tb_contatossubtipos    
    WHERE idcontatosubtipo = pidcontatosubtipo;

END