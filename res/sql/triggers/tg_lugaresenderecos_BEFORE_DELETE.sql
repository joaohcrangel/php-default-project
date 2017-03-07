CREATE DEFINER = CURRENT_USER TRIGGER tg_lugaresenderecos_BEFORE_DELETE BEFORE DELETE ON tb_lugaresenderecos FOR EACH ROW
BEGIN
	CALL sp_lugaresdados_save(OLD.idlugar);
END