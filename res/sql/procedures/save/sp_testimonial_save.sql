CREATE PROCEDURE sp_testimonial_save(
pidtestimony INT,
pidperson INT,
pdessubtitle VARCHAR(128),
pdestestimony VARCHAR(256)
)
BEGIN

    IF pidtestimony = 0 THEN
    
        INSERT INTO tb_testimonial (idperson, dessubtitle, destestimony)
        VALUES(pidperson, pdessubtitle, pdestestimony);
        
        SET pidtestimony = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_testimonial        
        SET 
            idperson = pidperson,
            dessubtitle = pdessubtitle,
            destestimony = pdestestimony    
        WHERE idtestimony = pidtestimony;

    END IF;

    CALL sp_testimonial_get(pidtestimony);

END