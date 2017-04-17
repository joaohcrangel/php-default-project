CREATE DEFINER = CURRENT_USER TRIGGER tg_lugarescoordenadas_AFTER_INSERT AFTER INSERT ON tb_lugarescoordenadas FOR EACH ROW
BEGIN
	CALL sp_lugaresdados_save(NEW.idlugar);
END