CREATE PROCEDURE sp_states_save(
pidstate INT,
pdesstate VARCHAR(64),
pdesuf CHAR(2),
pidcountry INT
)
BEGIN

    IF pidstate = 0 THEN
    
        INSERT INTO tb_states (desstate, desuf, idcountry)
        VALUES(pdesstate, pdesuf, pidcountry);
        
        SET pidstate = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_states        
        SET 
            desstate = pdesstate,
            desuf = pdesuf,
            idcountry = pidcountry
        WHERE idstate = pidstate;

    END IF;

    CALL sp_states_get(pidstate);

END