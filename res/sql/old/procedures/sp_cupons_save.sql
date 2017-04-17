CREATE PROCEDURE sp_cupons_save(
pidcupom INT,
pidcupomtipo INT,
pdescupom VARCHAR(128),
pdescodigo VARCHAR(128),
pnrqtd INT,
pnrqtdusado INT,
pdtinicio DATETIME,
pdttermino DATETIME,
pinremovido BIT(1),
pnrdesconto INT
)
BEGIN

    IF pidcupom = 0 THEN
    
		INSERT INTO tb_cupons(idcupomtipo, descupom, descodigo, nrqtd, nrqtdusado, dtinicio, dttermino, inremovido, nrdesconto)
        VALUES(pidcupomtipo, pdescupom, pdescodigo, pnrqtd, pnrqtdusado, pdtinicio, pdttermino, pinremovido, pnrdesconto);
        
        SET pidcupom = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_cupons SET
			idcupomtipo = pidcupomtipo,
            descupom = pdescupom,
            descodigo = pdescodigo,
			nrqtd = pnrqtd,
            nrqtdusado = pnrqtdusado,
            dtinicio = pdtinicio,
            dttermino = pdttermino,
            inremovido = pinremovido,
            nrdesconto = pnrdesconto
		WHERE idcupom = pidcupom;
	
    END IF;
    
    CALL sp_cupons_get(pidcupom);
        
END