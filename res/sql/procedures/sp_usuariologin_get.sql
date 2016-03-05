CREATE PROCEDURE sp_usuariologin_get(
pdesusuario VARCHAR(128),
pdessenha VARCHAR(256)
)
BEGIN
	
	DECLARE pidusuario INT;

    SELECT 
    idusuario INTO pidusuario    
    FROM tb_usuarios
    WHERE 
		desusuario = pdesusuario 
        AND 
        dessenha = MD5(pdessenha);
	
	IF pidusuario > 0 THEN
    
		CALL sp_usuario_get(pidusuario);
        
	END IF;

END