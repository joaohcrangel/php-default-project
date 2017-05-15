CREATE PROCEDURE sp_courses_save(
pidcourse INT,
pdescourse VARCHAR(64),
pdestitle VARCHAR(256),
pvlworkload DECIMAL(10,2),
pnrlessons INT,
pnrexercises INT,
pdesdescription VARCHAR(10240),
pinremoved tinyint(1)
)
BEGIN

    IF pidcourse = 0 THEN
    
        INSERT INTO tb_courses (descourse, destitle, vlworkload, nrlessons, nrexercises, desdescription, inremoved)
        VALUES(pdescourse, pdestitle, pvlworkload, pnrlessons, pnrexercises, pdesdescription, pinremoved);
        
        SET pidcourse = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_courses        
        SET 
            descourse = pdescourse,
            destitle = pdestitle,
            vlworkload = pvlworkload,
            nrlessons = pnrlessons,
            nrexercises = pnrexercises,
            desdescription = pdesdescription,
            inremoved = pinremoved        
        WHERE idcourse = pidcourse;

    END IF;

    CALL sp_courses_get(pidcourse);

END