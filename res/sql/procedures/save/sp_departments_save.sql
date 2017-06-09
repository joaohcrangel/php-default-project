CREATE PROCEDURE sp_departments_save(
piddepartment INT,
piddepartmentparent INT,
pdesdepartment VARCHAR(64),
pdtregister TIMESTAMP
)
BEGIN

    IF piddepartment = 0 THEN
    
        INSERT INTO tb_departments (iddepartmentparent, desdepartment, dtregister)
        VALUES(piddepartmentparent, pdesdepartment, pdtregister);
        
        SET piddepartment = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_departments        
        SET 
            iddepartmentparent = piddepartmentparent,
            desdepartment = pdesdepartment,
            dtregister = pdtregister        
        WHERE iddepartment = piddepartment;

    END IF;

    CALL sp_departments_get(piddepartment);

END;