DROP procedure IF EXISTS {$sp_list};

CREATE PROCEDURE {$sp_list}
BEGIN

    SELECT *   
    FROM {$table}
    WHERE {$primarykey[0]} = p{$primarykey[0]};

END;