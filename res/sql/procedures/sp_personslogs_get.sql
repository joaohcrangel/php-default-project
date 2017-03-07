CREATE PROCEDURE sp_personslogs_get(
pidpersonlog INT
)
BEGIN

    SELECT *    
    FROM tb_personslogs    
    WHERE idpersonlog = pidpersonlog;

END