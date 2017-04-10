CREATE PROCEDURE sp_carrinhosdados_save(
pidcarrinho INT
)
BEGIN

	DECLARE pvlpreco DECIMAL(10,2);
    DECLARE pnrprodutos INT;		
    DECLARE pidcupomtipo INT;
	DECLARE pnrdesconto DEC(10,2);
    
    SELECT SUM(c.vlpreco) AS vltotal, COUNT(c.idproduto) AS nrprodutos INTO pvlpreco, pnrprodutos FROM tb_carrinhos a
		INNER JOIN tb_carrinhosprodutos b ON a.idcarrinho = b.idcarrinho
		INNER JOIN tb_produtosprecos c ON b.idproduto = c.idproduto
	WHERE a.idcarrinho = pidcarrinho AND b.dtremovido IS NULL;
    
    UPDATE tb_carrinhos SET
		vltotal = pvlpreco,
        vltotalbruto = pvlpreco,
        nrprodutos = pnrprodutos
	WHERE idcarrinho = pidcarrinho;
    
    
    /* Atualizando o valor do carrinho com o frete */
    IF EXISTS(SELECT * FROM tb_carrinhosfretes WHERE idcarrinho = pidcarrinho) THEN
		UPDATE tb_carrinhos SET
			vltotal = vltotal + (SELECT vlfrete FROM tb_carrinhosfretes WHERE idcarrinho = pidcarrinho),
            vltotalbruto = vltotalbruto + (SELECT vlfrete FROM tb_carrinhosfretes WHERE idcarrinho = pidcarrinho)
		WHERE idcarrinho = pidcarrinho;
	END IF;
    
    
    /* Atualizando o valor do carrinho com cupom */
    IF EXISTS(SELECT * FROM tb_carrinhoscupons WHERE idcarrinho = pidcarrinho) THEN
		
		SELECT a.idcupomtipo, b.nrdesconto INTO pidcupomtipo, pnrdesconto FROM tb_cuponstipos a
			INNER JOIN tb_cupons b ON a.idcupomtipo = b.idcupomtipo
			INNER JOIN tb_carrinhoscupons c ON b.idcupom = c.idcupom
		WHERE c.idcarrinho = pidcarrinho;
		
		IF pidcupomtipo = 1 THEN
		
			UPDATE tb_carrinhos SET
				vltotal = vltotal - pnrdesconto
			WHERE idcarrinho = pidcarrinho;
		
		ELSE
		
			UPDATE tb_carrinhos SET
				vltotal = vltotal - ((vltotal * pnrdesconto) / 100)
			WHERE idcarrinho = pidcarrinho;
											
		END IF;
		
	END IF;
    

END