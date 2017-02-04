CREATE PROCEDURE sp_pessoastipos_remove(
pidpessoatipo INT
)
BEGIN

    DELETE FROM tb_pessoastipos 
    WHERE idpessoatipo = pidpessoatipo;

END