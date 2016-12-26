CREATE PROCEDURE sp_contatos_remove(
pidcontato INT
)
BEGIN

    DELETE FROM tb_contatos WHERE idcontato = pidcontato;

END