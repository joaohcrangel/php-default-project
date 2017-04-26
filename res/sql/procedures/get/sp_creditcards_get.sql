CREATE PROCEDURE sp_creditcards_get(
pidcard INT
)
BEGIN
	
	SELECT * FROM tb_creditcards a INNER JOIN tb_persons b USING(idperson)
    WHERE idcard = pidcard;

END