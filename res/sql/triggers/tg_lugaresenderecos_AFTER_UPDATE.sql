CREATE DEFINER = CURRENT_USER TRIGGER tg_lugaresenderecos_AFTER_UPDATE AFTER UPDATE ON tb_lugaresenderecos FOR EACH ROW
BEGIN
	CALL sp_lugaresdados_save(NEW.idlugar);
END