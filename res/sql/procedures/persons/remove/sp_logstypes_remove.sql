CREATE PROCEDURE sp_logstypes_remove(
pidlogtype INT
)
BEGIN

    DELETE FROM tb_logstypes 
    WHERE idlogtype = pidlogtype;

END