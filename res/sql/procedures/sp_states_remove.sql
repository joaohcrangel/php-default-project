CREATE PROCEDURE sp_states_remove(
pidstate INT
)
BEGIN

	IF EXISTS(SELECT * FROM tb_cities WHERE idstate = pidstate) THEN

		DELETE FROM tb_cities WHERE idstate = pidstate;

	END IF;

    DELETE FROM tb_states 
    WHERE idstate = pidstate;

END