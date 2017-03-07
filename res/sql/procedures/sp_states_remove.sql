CREATE PROCEDURE sp_states_remove(
pidstate INT
)
BEGIN

    DELETE FROM tb_states 
    WHERE idstate = pidstate;

END