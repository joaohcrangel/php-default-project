CREATE PROCEDURE sp_filesfromevents_save(
pidcalendar INT,
pidfile INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_eventscalendarsfiles WHERE idcalendar = pidcalendar AND idfile = pidfile) THEN

		INSERT INTO tb_eventscalendarsfiles(idcalendar, idfile) VALUES(pidcalendar, pidfile);

	END IF;

END