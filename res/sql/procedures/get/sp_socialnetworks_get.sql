CREATE PROCEDURE sp_socialnetworks_get(
pidsocialnetwork INT
)
BEGIN

    SELECT *    
    FROM tb_socialnetworks    
    WHERE idsocialnetwork = pidsocialnetwork;

END