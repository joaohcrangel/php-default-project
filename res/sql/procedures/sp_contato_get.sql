CREATE PROCEDURE sp_contato_get(
pidcontato INT
)
BEGIN

    SELECT
    idcontato, idcontatotipo, idpessoa, descontato, dtcadastro
    
    FROM tb_contatos

    WHERE idcontato = pidcontato;

END