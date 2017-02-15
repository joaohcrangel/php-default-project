CREATE PROCEDURE sp_arquivos_save(
pidarquivo INT,
pdesdiretorio VARCHAR(256),
pdesarquivo VARCHAR(128),
pdesextensao VARCHAR(32),
pdesalias VARCHAR(128)
)
BEGIN

    IF pidarquivo = 0 THEN
    
        INSERT INTO tb_arquivos (desdiretorio, desarquivo, desextensao, desalias)
        VALUES(pdesdiretorio, pdesarquivo, pdesextensao, pdesalias);
        
        SET pidarquivo = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_arquivos        
        SET 
            desdiretorio = pdesdiretorio,
            desarquivo = pdesarquivo,
            desextensao = pdesextensao,
            desalias = pdesalias
        WHERE idarquivo = pidarquivo;

    END IF;

    CALL sp_arquivos_get(pidarquivo);

END