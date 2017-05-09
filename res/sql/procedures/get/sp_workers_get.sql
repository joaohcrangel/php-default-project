CREATE PROCEDURE sp_workers_get(
pidworker INT
)
BEGIN

    SELECT a.*, b.*, c.desjobposition, CONCAT(d.desdirectory, d.desfile, '.', d.desextension) AS desphoto FROM tb_workers a
		INNER JOIN tb_persons b ON a.idperson = b.idperson
		INNER JOIN tb_jobspositions c ON a.idjobposition = c.idjobposition
		LEFT JOIN tb_files d ON a.idphoto = d.idfile
    WHERE idworker = pidworker;

END;