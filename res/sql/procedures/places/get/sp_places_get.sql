CREATE PROCEDURE sp_places_get(
pidplace INT
)
BEGIN

	SELECT a.*, b.idaddresstype, b.desaddress, b.desnumber, b.desdistrict, b.descity, b.desstate, b.descountry, b.descep, b.descomplement,
			c.desplacetype, d.idcoordinate, d.vllatitude, d.vllongitude, d.nrzoom
	FROM tb_places a
		LEFT JOIN tb_placesaddresses b1 ON a.idplace = b1.idplace
		LEFT JOIN tb_addresses b ON b1.idaddress = b.idaddress
        LEFT JOIN tb_placestypes c ON a.idplacetype = c.idplacetype
        LEFT JOIN tb_placescoordinates d1 ON d1.idplace = a.idplace
        LEFT JOIN tb_coordinates d ON d.idcoordinate = d1.idcoordinate
    WHERE a.idplace = pidplace;

END