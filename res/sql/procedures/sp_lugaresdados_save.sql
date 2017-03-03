CREATE PROCEDURE sp_lugaresdados_save(
pidlugar INT
)
BEGIN

    CALL sp_lugaresdados_remove(pidlugar);
    
    INSERT INTO tb_lugaresdados(
        idlugar, deslugar,
        idlugarpai, deslugarpai,
        idlugartipo, deslugartipo,
        idenderecotipo, desenderecotipo,
        idendereco, desendereco,
        desnumero, desbairro, descidade,
        desestado, despais,
        descep, descomplemento,
        idcoordenada,
        vllatitude, vllongitude,
        nrzoom, dtcadastro
    )
    SELECT
    a.idlugar, a.deslugar,
    a1.idlugar, a1.deslugar,
    a2.idlugartipo, a2.deslugartipo,
    b.idenderecotipo, b.desenderecotipo,
    c.idendereco, c.desendereco,
    c.desnumero, c.desbairro, c.descidade,
    c.desestado, c.despais,
    c.descep, c.descomplemento,
    d.idcoordenada,
    d.vllatitude, d.vllongitude,
    d.nrzoom, NOW()
    FROM tb_lugares a
    LEFT JOIN tb_lugares a1 ON a1.idlugar = (SELECT idlugarpai FROM tb_lugares WHERE idlugar = a.idlugar)
    INNER JOIN tb_lugarestipos a2 ON a.idlugartipo = a2.idlugartipo
    LEFT JOIN tb_lugaresenderecos c1 ON a.idlugar = c1.idlugar
    LEFT JOIN tb_enderecos c ON c1.idendereco = c.idendereco
    LEFT JOIN tb_enderecostipos b ON b.idenderecotipo = c.idenderecotipo
    LEFT JOIN tb_lugarescoordenadas e ON e.idlugar = a.idlugar
    LEFT JOIN tb_coordenadas d ON e.idcoordenada = d.idcoordenada
    WHERE a.idlugar = pidlugar
    LIMIT 1;

END