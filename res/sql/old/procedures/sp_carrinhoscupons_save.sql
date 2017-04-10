CREATE PROCEDURE sp_carrinhoscupons_save(
pidcarrinho INT,
pidcupom INT
)
BEGIN

    IF NOT EXISTS(SELECT * FROM tb_carrinhoscupons WHERE idcarrinho = pidcarrinho AND idcupom = pidcupom) THEN

    	INSERT INTO tb_carrinhoscupons(idcarrinho, idcupom)
    	VALUES(pidcarrinho, pidcupom);

    END IF;

END