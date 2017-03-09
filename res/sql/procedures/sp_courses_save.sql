CREATE PROCEDURE sp_courses_save(
pidcourse INT,
pdescourse VARCHAR(64),
pdestitle VARCHAR(256),
pvlhours DECIMAL(10,2),
pnrclassrooms INT,
pnrexercise INT,
pdesdescription VARCHAR(10240),
pinremoved BIT
)
BEGIN

    IF pidcurso = 0 THEN
    
        INSERT INTO tb_courses (descourse, destitle, vlhours, nrclassrooms, nrexercise, desdescription, inremoved)
        VALUES(pdescourse, pdestitle, pvlhours, pnrclassrooms, pnrexercise, pdesdescription, pinremoved);
        
        SET pidcourse = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_courses        
        SET 
            descourse = pdescourse,
            destitle = pdestitle,
            vlhours = pvlhours,
            nrclassrooms = pnrclassrooms,
            nrexercise = pnrexercise,
            desdescription = pdesdescription,
            inremoved = pinremoved        
        WHERE idcourse = pidcourse;

    END IF;

    CALL sp_courses_get(pidcourse);

END