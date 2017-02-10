CREATE DEFINER = CURRENT_USER TRIGGER tg_lugarescoordenadas_AFTER_UPDATE AFTER UPDATE ON tb_lugarescoordenadas FOR EACH ROW
BEGIN
	CALL sp_lugaresdados_save(NEW.idlugar);
END