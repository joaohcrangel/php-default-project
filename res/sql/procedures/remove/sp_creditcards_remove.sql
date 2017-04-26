CREATE PROCEDURE sp_creditcards_remove(
pidcard INT
)
BEGIN
	
	DELETE FROM tb_creditcards WHERE idcard = pidcard;

END