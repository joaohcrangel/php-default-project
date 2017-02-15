CREATE PROCEDURE sp_cursos_save(
pidcurso INT,
pdescurso VARCHAR(64),
pdestittulo VARCHAR(256),
pvlcargahoraria DECIMAL(10,2),
pnraulas INT,
pnrexercicios INT,
pdesdescricao VARCHAR(10240),
pinremovido BIT
)
BEGIN

    IF pidcurso = 0 THEN
    
        INSERT INTO tb_cursos (descurso, destittulo, vlcargahoraria, nraulas, nrexercicios, desdescricao, inremovido)
        VALUES(pdescurso, pdestittulo, pvlcargahoraria, pnraulas, pnrexercicios, pdesdescricao, pinremovido);
        
        SET pidcurso = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_cursos        
        SET 
            descurso = pdescurso,
            destittulo = pdestittulo,
            vlcargahoraria = pvlcargahoraria,
            nraulas = pnraulas,
            nrexercicios = pnrexercicios,
            desdescricao = pdesdescricao,
            inremovido = pinremovido        
        WHERE idcurso = pidcurso;

    END IF;

    CALL sp_cursos_get(pidcurso);

END