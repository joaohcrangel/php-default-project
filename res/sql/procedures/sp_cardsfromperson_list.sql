CREATE PROCEDURE sp_cardsfromperson_list (
pidperson INT
)
BEGIN

	SELECT * FROM tb_cardsdecreditos WHERE idperson = pidperson;

END
