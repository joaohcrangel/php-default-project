CREATE PROCEDURE sp_users_save(
piduser INT,
pidperson INT,
pdesuser VARCHAR(128),
pdespassword VARCHAR(256),
pinblocked BIT,
pidusertype INT
)
BEGIN

    IF piduser = 0 THEN
    
        INSERT INTO tb_users (idperson, desuser, despassword, inblocked, idusertype)
        VALUES(pidperson, pdesuser, pdespassword, pinblocked, pidusertype);
        
        SET piduser = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_users SET 
            idperson = pidperson,
            desuser = pdesuser,
            despassword = pdespassword,
            inblocked = pinblocked,
            idusertype = pidusertype
        WHERE iduser = piduser;

    END IF;

    CALL sp_users_get(piduser);

END