CREATE PROCEDURE sp_usuarioslogin_get(
pdesusuario VARCHAR(128)
)
BEGIN
	
	DECLARE pidusuario INT;

    SELECT 
    idusuario INTO pidusuario    
    FROM tb_usuarios
    WHERE 
		desusuario = pdesusuario;
	
	IF pidusuario > 0 THEN
    
		CALL sp_usuarios_get(pidusuario);
        
	END IF;

END