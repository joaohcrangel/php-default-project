CREATE PROCEDURE {$sp_get}(
p{$primarykey[0]} INT
)
BEGIN

    SELECT *    
    FROM {$table}
    
    WHERE {$primarykey[0]} = p{$primarykey[0]};

END;