CREATE PROCEDURE sp_pessoastipos_get(
pidpessoatipo INT
)
BEGIN

    SELECT *    
    FROM tb_pessoastipos    
    WHERE idpessoatipo = pidpessoatipo;

END