CREATE PROCEDURE sp_personslogs_remove(
pidpersonlog INT
)
BEGIN

    DELETE FROM tb_personslogs 
    WHERE idpersonlog = pidpersonlog;

END