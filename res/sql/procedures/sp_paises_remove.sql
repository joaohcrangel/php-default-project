CREATE PROCEDURE sp_paises_remove(
pidpais INT
)
BEGIN

    DELETE FROM tb_paises 
    WHERE idpais = pidpais;

END