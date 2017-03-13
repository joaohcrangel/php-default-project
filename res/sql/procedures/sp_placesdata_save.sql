CREATE PROCEDURE sp_placesdata_save(
pidplace INT
)
BEGIN

    CALL sp_placesdata_remove(pidplace);
    
    INSERT INTO tb_placesdata(
        idplace, desplace,
        idplacefather, desplacefather,
        idplacetype, desplacetype,
        idaddresstype, desaddresstype,
        idaddress, desaddress,
        desnumber, desdistrict, descity,
        desstate, descountry,
        descep, descomplement,
        idcoordinate,
        vllatitude, vllongitude,
        nrzoom, dtregister
    )
    SELECT
    a.idplace, a.desplace,
    a1.idplace, a1.desplace,
    a2.idplacetype, a2.desplacetype,
    b.idaddresstype, b.desaddresstype,
    c.idaddress, c.desaddress,
    c.desnumber, c.desdistrict, c.descity,
    c.desstate, c.descountry,
    c.descep, c.descomplement,
    d.idcoordinate,
    d.vllatitude, d.vllongitude,
    d.nrzoom, NOW()
    FROM tb_places a
    LEFT JOIN tb_places a1 ON a1.idplace = (SELECT idplacefather FROM tb_places WHERE idplace = a.idplace)
    INNER JOIN tb_placestypes a2 ON a.idplacetype = a2.idplacetype
    LEFT JOIN tb_placesaddresses c1 ON a.idplace = c1.idplace
    LEFT JOIN tb_addresses c ON c1.idaddress = c.idaddress
    LEFT JOIN tb_addressestypes b ON b.idaddresstype = c.idaddresstype
    LEFT JOIN tb_placescoordinates e ON e.idplace = a.idplace
    LEFT JOIN tb_coordinates d ON e.idcoordinate = d.idcoordinate
    WHERE a.idplace = pidplace
    LIMIT 1;

END