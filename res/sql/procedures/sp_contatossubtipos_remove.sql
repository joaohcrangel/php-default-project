<<<<<<< HEAD

=======
>>>>>>> e30a5606f0ab3e0529df51c8c469cb81090b2093
CREATE PROCEDURE sp_contatossubtipos_remove(
pidcontatosubtipo INT
)
BEGIN

    DELETE FROM tb_contatossubtipos 
    WHERE idcontatosubtipo = pidcontatosubtipo;

END