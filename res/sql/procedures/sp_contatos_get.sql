CREATE PROCEDURE sp_contatos_get(
pidcontato INT
)
BEGIN

    SELECT *    
    FROM tb_contatos
    WHERE idcontato = pidcontato;

END