CREATE PROCEDURE sp_productsurls_save(
pidproduct INT,
pidurl INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_productsurls WHERE idproduct = pidproduct AND idurl = pidurl) THEN

		INSERT INTO tb_productsurls(idproduct, idurl) VALUES(pidproduct, pidurl);

	END IF;

END