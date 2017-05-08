CREATE PROCEDURE sp_workers_list()
BEGIN

	SELECT a.*, c.descategory, g.desvalue AS desphoto FROM tb_persons a
		INNER JOIN tb_personscategories b ON a.idperson = b.idperson
		INNER JOIN tb_personscategoriestypes c ON b.idcategory = c.idcategory
		LEFT JOIN tb_personssocialnetworks d ON a.idperson = d.idperson
		LEFT JOIN tb_socialnetworks e ON d.idsocialnetwork = e.idsocialnetwor
		LEFT JOIN tb_personsvalues f ON a.idperson = f.idperson
		LEFT JOIN tb_personsvaluesfields g ON f.idfield = g.idfield
	WHERE c.idcategory IN(6, 7) AND g.idfield = 5
	GROUP BY b.idcategory;

END