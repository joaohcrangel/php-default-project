CREATE PROCEDURE sp_emailsblacklists_remove(
pidblacklist INT
)
BEGIN

    DELETE FROM tb_emailsblacklists 
    WHERE idblacklist = pidblacklist;

END