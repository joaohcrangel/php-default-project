CREATE PROCEDURE sp_socialnetworks_remove(
pidsocialnetwork INT
)
BEGIN

    DELETE FROM tb_socialnetworks 
    WHERE idsocialnetwork = pidsocialnetwork;

END