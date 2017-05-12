CREATE PROCEDURE sp_testimonial_list()
BEGIN

    SELECT a.*, b.desperson, CONCAT(d.desdirectory, d.desfile, '.', d.desextension) AS desphoto FROM tb_testimonial a
    	INNER JOIN tb_personsdata b ON a.idperson = b.idperson
    	LEFT JOIN tb_personsfiles c ON b.idperson = c.idperson
    	LEFT JOIN tb_files d ON c.idfile = d.idfile
    GROUP BY a.idtestimony;

    SELECT a.*, b.desperson, e.desvalue AS desphoto FROM tb_testimonial a
    	INNER JOIN tb_personsdata b ON a.idperson = b.idperson
    	LEFT JOIN tb_personsfiles c ON b.idperson = c.idperson
    	LEFT JOIN tb_files d ON c.idfile = d.idfile
    	LEFT JOIN tb_personsvalues e ON a.idperson = e.idperson
    	LEFT JOIN tb_personsvaluesfields f ON e.idfield = f.idfield
    WHERE e.idfield = 4 GROUP BY a.idtestimony;

END