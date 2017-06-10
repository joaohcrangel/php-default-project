CREATE PROCEDURE sp_eventsdata_save(
pidevent INT
)
BEGIN

	CALL sp_eventsdata_remove(pidevent);

	INSERT INTO tb_eventsdata(
		idevent, desevent,
		idfrequency, desfrequency, nrfrequency,
		idorganizer, desorganizer,
		dtstart, dtend,
		idurl, desurl, idplace,
		deslogo, desbanner, dtregister
	)
	SELECT
		a.idevent, a.desevent,
		a.idfrequency, b.desfrequency, a.nrfrequency,
		a.idorganizer, c.desorganizer,
		d.dtstart, d.dtend,
		d.idurl, e.desurl, d.idplace,
		f.desvalue, g.desvalue, NOW()
	FROM tb_events a
		INNER JOIN tb_eventsfrequencies b ON a.idfrequency = b.idfrequency
		INNER JOIN tb_eventsorganizers c ON a.idorganizer = c.idorganizer
		INNER JOIN tb_eventscalendars d ON a.idevent = d.idevent
		LEFT JOIN tb_urls e ON d.idurl = e.idurl
		LEFT JOIN tb_eventsschedulesvalues f ON f.idcalendar = d.idcalendar AND f.idproperty = 1 -- Logo
		LEFT JOIN tb_eventsschedulesvalues g ON g.idcalendar = d.idcalendar AND g.idproperty = 2 -- Banner
	WHERE a.idevent = pidevent;

END