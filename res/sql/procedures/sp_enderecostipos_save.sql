CREATE PROCEDURE sp_enderecostipos_save(
pidenderecotipo INT,
pdesenderecotipo VARCHAR(64)
)
BEGIN

    IF pidenderecotipo = 0 THEN
    
        INSERT INTO tb_enderecostipos(desenderecotipo) VALUES(pdesenderecotipo);
        
        SET pidenderecotipo = LAST_INSERT_ID();
        
    ELSE
    
        UPDATE tb_enderecostipos SET
            desenderecotipo = pdesenderecotipo
        WHERE idenderecotipo = pidenderecotipo;
        
    END IF;
    
    CALL sp_enderecostipos_get(pidenderecotipo);

END