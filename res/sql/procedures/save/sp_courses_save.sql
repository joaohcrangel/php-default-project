CREATE PROCEDURE sp_courses_save(
pidcourse INT,
pdescourse VARCHAR(64),
pdestitle VARCHAR(256),
pvlworkload TIME,
pnrlessons INT,
pnrexercises INT,
pidbanner INT,
pidbrasao INT,
pdesdescription TEXT,
pdesshortdescription VARCHAR(512),
pdeswhatlearn TEXT,
pdesrequirements TEXT,
pdestargetaudience TEXT,
pinremoved TINYINT(1),
pdesurludemy VARCHAR(128),
pidcourseudemy INT
)
BEGIN

    IF pidcourse = 0 THEN
    
        INSERT INTO tb_courses (descourse, destitle, vlworkload, nrlessons, nrexercises, idbanner, idbrasao, desdescription, desshortdescription, deswhatlearn, desrequirements, destargetaudience, inremoved, desurludemy, idcourseudemy)
        VALUES(pdescourse, pdestitle, pvlworkload, pnrlessons, pnrexercises, pidbanner, pidbrasao, pdesdescription, pdesshortdescription, pdeswhatlearn, pdesrequirements, pdestargetaudience, pinremoved, pdesurludemy, pidcourseudemy);
        
        SET pidcourse = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_courses        
        SET 
            descourse = pdescourse,
            destitle = pdestitle,
            vlworkload = pvlworkload,
            nrlessons = pnrlessons,
            nrexercises = pnrexercises,
            idbanner = pidbanner,
            idbrasao = pidbrasao,
            desdescription = pdesdescription,
            desshortdescription = pdesshortdescription,
            deswhatlearn = pdeswhatlearn,
            desrequirements = pdesrequirements,
            destargetaudience = pdestargetaudience,
            inremoved = pinremoved,
            desurludemy = pdesurludemy,
            idcourseudemy = pidcourseudemy
        WHERE idcourse = pidcourse;

    END IF;

    CALL sp_courses_get(pidcourse);

END