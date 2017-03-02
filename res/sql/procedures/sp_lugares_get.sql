CREATE PROCEDURE sp_lugares_get(
pidlugar INT
)
BEGIN

	SELECT a.*, b.idenderecotipo, b.desendereco, b.desnumero, b.desbairro, b.descidade, b.desestado, b.despais, b.descep, b.descomplemento,
			c.deslugartipo, d.idcoordenada, d.vllatitude, d.vllongitude, d.nrzoom
	FROM tb_lugares a
		LEFT JOIN tb_lugaresenderecos b1 ON a.idlugar = b1.idlugar
		LEFT JOIN tb_enderecos b ON b1.idendereco = b.idendereco
        LEFT JOIN tb_lugarestipos c ON a.idlugartipo = c.idlugartipo
        LEFT JOIN tb_lugarescoordenadas d1 ON d1.idlugar = a.idlugar
        LEFT JOIN tb_coordenadas d ON d.idcoordenada = d1.idcoordenada
    WHERE a.idlugar = pidlugar;

END