CREATE DEFINER = CURRENT_USER TRIGGER tg_eventscalendars_BEFORE_DELETE BEFORE DELETE ON tb_eventscalendars FOR EACH ROW
BEGIN
	CALL sp_eventsdata_remove(OLD.idevent);
END