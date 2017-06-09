CREATE PROCEDURE sp_workersroleslogs_save(
pidhistory INT,
pidworker INT,
pidrole INT,
pvlsalary DECIMAL(10,2),
pdtstart DATE,
pdtend DATE,
pdtregister TIMESTAMP
)
BEGIN

    IF pidhistory = 0 THEN
    
        INSERT INTO tb_workersroleslogs (idworker, idrole, vlsalary, dtstart, dtend, dtregister)
        VALUES(pidworker, pidrole, pvlsalary, pdtstart, pdtend, pdtregister);
        
        SET pidhistory = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_workersroleslogs        
        SET 
            idworker = pidworker,
            idrole = pidrole,
            vlsalary = pvlsalary,
            dtstart = pdtstart,
            dtend = pdtend,
            dtregister = pdtregister        
        WHERE idhistory = pidhistory;

    END IF;

    CALL sp_workersroleslogs_get(pidhistory);

END;