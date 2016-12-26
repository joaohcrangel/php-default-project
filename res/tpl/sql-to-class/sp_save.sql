CREATE PROCEDURE {$sp_save}(
{$fieldssaveparams}
)
BEGIN

    IF p{$primarykey[0]} = 0 THEN
    
        INSERT INTO {$table} ({$fieldsinsert})
        VALUES({$fieldsinsertp});
        
        SET p{$primarykey[0]} = LAST_INSERT_ID();

    ELSE
        
        UPDATE {$table}
        
        SET 
            {$fieldsupdate}
        
        WHERE {$primarykey[0]} = p{$primarykey[0]};

    END IF;

    CALL {$sp_get}(p{$primarykey[0]});

END;