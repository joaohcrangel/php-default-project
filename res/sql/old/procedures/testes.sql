-- editando valor do carrinho
UPDATE tb_carrinhos
SET vltotal = (SELECT SUM(a.vlpreco * (SELECT COUNT(idproduto) FROM tb_carrinhosprodutos WHERE idcarrinho = 1 AND idproduto = a.idproduto)) AS vltotal FROM tb_produtosprecos a)
WHERE idcarrinho = 1; 

SELECT SUM(a.vlpreco * (SELECT COUNT(idproduto) FROM tb_carrinhosprodutos WHERE idcarrinho = 1 AND idproduto = a.idproduto)) AS vltotal FROM tb_produtosprecos a;

SELECT SUM(c.vlpreco), COUNT(c.idproduto) FROM tb_carrinhos a
	INNER JOIN tb_carrinhosprodutos b ON a.idcarrinho = b.idcarrinho
    INNER JOIN tb_produtosdados c ON b.idproduto = c.idproduto
WHERE a.idcarrinho = 1;


-- editando valor do carrinho com frete
IF EXISTS(SELECT * FROM tb_carrinhosfretes WHERE idcarrinho = pidcarrinho) THEN
	UPDATE tb_carrinhos SET
		vlpreco = vlpreco + (SELECT vlfrete FROM tb_carrinhosfretes WHERE idcarrinho = pidcarrinho);
END IF;


-- editando valor do carrinho com cupom
IF EXISTS(SELECT * FROM tb_carrinhoscupons WHERE idcarrinho = pidcarrinho) THEN

	DECLARE pidcupomtipo INT;
    DECLARE pnrdesconto DEC(10,2);
	
    SELECT a.idcupomtipo, b.nrdesconto INTO pidcupomtipo, pnrdesconto FROM tb_cuponstipos
		INNER JOIN tb_cupons b ON a.idcupomtipo = b.idcupomtipo
		INNER JOIN tb_carrinhoscupons c ON b.idcupom = c.idcupom
	WHERE c.idcarrinho = pidcarrinho;
    
    IF pidcupomtipo = 1 THEN
    
		UPDATE tb_carrinhos SET
			vltotal = vltotal - (SELECT nrdesconto FROM tb_cupons a INNER JOIN tb_carrinhoscupons b ON a.idcupom = b.idcupom WHERE b.idcarrinho = pidcarrinho);
	
    ELSE
    
		UPDATE tb_carrinhos SET
			vltotal = ((vltotal * pnrdesconto) / 100)
                                        
	END IF;
    
END IF;