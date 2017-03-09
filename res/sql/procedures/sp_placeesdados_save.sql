CREATE PROCEDURE sp_placeesdatas_save(
pidlugar INT
)
BEGIN

    CALL sp_placeesdatas_remove(pidplace);
    
    INSERT INTO tb_placeesdatas(
        idplace, desidplace,
        idplacefather, desplacefather,
        idplacetype, desplacetype,
        idadresstype, desadresstype,
        idadress, desadress,
        desnumber, desdistrict, descity,
        desstate, descountry,
        deszipcode, descomplement,
        idcoordinate,
        vllatitude, vllongitude,
        nrzoom, dtregister
    )
    SELECT
    a.idplace, a.desplace,
    a1.idplace, a1.desplace,
    a2.idplacetype, a2.desplacetype,
    b.idadresstype, b.desadresstype,
    c.idadress, c.desadress,
    c.desnumber, c.desdistrict, c.descity,
    c.desstate, c.descountry,
    c.deszipcode, c.descomplement,
    d.idcoordinate,
    d.vllatitude, d.vllongitude,
    d.nrzoom, NOW()
    FROM tb_placees a
    LEFT JOIN tb_placees a1 ON a1.idplace = (SELECT idplacefather FROM tb_placees WHERE idplace = a.idplace)
    INNER JOIN tb_placeestypes a2 ON a.idplacetype = a2.idplacetype
    LEFT JOIN tb_placeesadresses c1 ON a.idplace = c1.idplace
    LEFT JOIN tb_adresses c ON c1.idadress = c.idadress
    LEFT JOIN tb_adressestypes b ON b.idadresstype = c.idadresstype
    LEFT JOIN tb_placeescoordinates e ON e.idplace = a.idplace
    LEFT JOIN tb_coordinates d ON e.idcoordinate = d.idcoordinate
    WHERE a.idplace = pidplace
    LIMIT 1;

END