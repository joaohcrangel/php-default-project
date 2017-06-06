CREATE DEFINER = CURRENT_USER TRIGGER tg_files_AFTER_INSERT AFTER INSERT ON tb_files FOR EACH ROW
BEGIN
	IF @disabled_triggers = 0 THEN
		CALL sp_filestrigger_save(NEW.idfile);
	END IF;
END