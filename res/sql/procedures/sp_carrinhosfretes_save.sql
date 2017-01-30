CREATE PROCEDURE sp_carrinhosfretes_save(
pidcarrinho INT,
pdescep CHAR(8),
pvlfrete INT
)
BEGIN

    IF NOT EXISTS(SELECT * FROM tb_carrinhosfretes WHERE idcarrinho = pidcarrinho) THEN

    	INSERT INTO tb_carrinhosfretes(idcarrinho, descep, vlfrete)
    	VALUES(pidcarrinho, pdescep, pvlfrete);

    ELSE

    	UPDATE tb_carrinhosfretes SET
    		descep = pdescep,
    		vlfrete = pvlfrete
    	WHERE idcarrinho = pidcarrinho;

    END IF;

    CALL sp_carrinhosfretes_get(pidcarrinho);

END