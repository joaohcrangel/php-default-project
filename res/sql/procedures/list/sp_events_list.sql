CREATE PROCEDURE sp_events_list()
BEGIN

	SELECT * FROM tb_events
		INNER JOIN tb_eventscalendars USING(idevent);

END