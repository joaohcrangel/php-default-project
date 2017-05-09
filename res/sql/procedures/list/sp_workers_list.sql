CREATE PROCEDURE sp_workers_list()
BEGIN

	SELECT a.*, b.*, c.desjobposition, CONCAT(d.desdirectory, d.desfile, '.', d.desextension) AS desphoto FROM tb_personsdata a
		INNER JOIN tb_workers b ON a.idperson = b.idperson
		INNER JOIN tb_jobspositions c ON b.idjobposition = c.idjobposition
		LEFT JOIN tb_files d ON b.idphoto = d.idfile;

END