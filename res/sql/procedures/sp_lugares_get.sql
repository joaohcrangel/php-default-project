CREATE PROCEDURE sp_lugares_get(
pidlugar INT
)
BEGIN

	SELECT a.*, b.idenderecotipo, b.desendereco, b.desnumero, b.desbairro, b.descidade, b.desestado, b.despais, b.descep, b.descomplemento,
			c.deslugartipo
	FROM tb_lugares a
		INNER JOIN tb_enderecos b ON a.idendereco = b.idendereco
        INNER JOIN tb_lugarestipos c ON a.idlugartipo = c.idlugartipo    
    WHERE a.idlugar = pidlugar;

END