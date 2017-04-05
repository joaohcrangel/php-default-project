CREATE PROCEDURE sp_emailsblacklists_get(
pidblacklist INT
)
BEGIN

    SELECT *    
    FROM tb_emailsblacklists    
    WHERE idblacklist = pidblacklist;

END