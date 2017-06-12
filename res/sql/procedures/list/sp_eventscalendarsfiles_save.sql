CREATE PROCEDURE sp_filesfromevents_list(
pidcalendar INT
)
BEGIN

	SELECT a.*, b.despath FROM tb_files a
		INNER JOIN tb_filespaths b ON a.idfile = b.idfile
		INNER JOIN tb_eventscalendarsfiles c ON c.idfile = a.idfile
	WHERE c.idcalendar = pidcalendar;

END