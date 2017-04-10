CREATE PROCEDURE sp_logstypes_get(
pidlogtype INT
)
BEGIN

    SELECT *    
    FROM tb_logstypes    
    WHERE idlogtype = pidlogtype;

END