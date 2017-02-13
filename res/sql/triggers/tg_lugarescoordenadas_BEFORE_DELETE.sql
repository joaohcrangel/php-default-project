CREATE DEFINER = CURRENT_USER TRIGGER tg_lugarescoordenadas_BEFORE_DELETE BEFORE DELETE ON tb_lugarescoordenadas FOR EACH ROW
BEGIN
	CALL sp_lugaresdados_save(OLD.idlugar);
END