CREATE PROCEDURE {$sp_remove}(
p{$primarykey[0]} INT
)
BEGIN

    DELETE FROM {$table} 
    WHERE {$primarykey[0]} = p{$primarykey[0]};

END;