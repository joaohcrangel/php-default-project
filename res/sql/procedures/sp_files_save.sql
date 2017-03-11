CREATE PROCEDURE sp_files_save(
pidfile INT,
pdesdirectory VARCHAR(256),
pdesfile VARCHAR(128),
pdesextension VARCHAR(32),
pdesalias VARCHAR(128)
)
BEGIN

    IF pidfile = 0 THEN
    
        INSERT INTO tb_files (desdirectory, desfile, desextension, desalias)
        VALUES(pdesdirectory, pdesfile, pdesextension, pdesalias);
        
        SET pidfile = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_files        
        SET 
            desdirectory = pdesdirectory,
            desfile = pdesfile,
            desextension = pdesextension,
            desalias = pdesalias
        WHERE idfile = pidfile;

    END IF;

    CALL sp_files_get(pidfile);

END