CREATE PROCEDURE sp_contato_remove(
pidcontato INT
)
BEGIN

    DELETE FROM tb_contatos WHERE idcontato = pidcontato;

END