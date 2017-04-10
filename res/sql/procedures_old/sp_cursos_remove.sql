CREATE PROCEDURE sp_cursos_remove(
pidcurso INT
)
BEGIN

    DELETE FROM tb_cursos 
    WHERE idcurso = pidcurso;

END