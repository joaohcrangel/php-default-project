CREATE PROCEDURE sp_instructors_save(
pidinstructor INT,
pidperson INT,
pdesbiography TEXT,
pidphoto INT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidinstructor = 0 THEN
    
        INSERT INTO tb_instructors (idperson, desbiography, idphoto, dtregister)
        VALUES(pidperson, pdesbiography, pidphoto, pdtregister);
        
        SET pidinstructor = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_instructors        
        SET 
            idperson = pidperson,
            desbiography = pdesbiography,
            idphoto = pidphoto,
            dtregister = pdtregister        
        WHERE idinstructor = pidinstructor;

    END IF;

    CALL sp_instructors_get(pidinstructor);

END;