CREATE PROCEDURE sp_usuariosfromemail_get(
pdesemail VARCHAR(64)
)
BEGIN
	
	DECLARE pidusuario INT;

    SELECT 
    idusuario INTO pidusuario    
    FROM tb_usuarios a
    INNER JOIN tb_contatos b USING(idpessoa)
    WHERE 
		b.descontato = pdesemail
        AND
        b.idcontatotipo = 1;
	
	IF pidusuario > 0 THEN
    
		CALL sp_usuario_get(pidusuario);
        
	END IF;

END