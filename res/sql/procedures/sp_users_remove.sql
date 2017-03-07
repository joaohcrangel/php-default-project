CREATE PROCEDURE sp_users_remove(
piduser INT
)
BEGIN

    DELETE FROM tb_users 
    WHERE iduser = piduser;

END