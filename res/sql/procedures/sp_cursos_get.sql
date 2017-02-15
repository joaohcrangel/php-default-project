CREATE PROCEDURE sp_cursos_get(
pidcurso INT
)
BEGIN

    SELECT *    
    FROM tb_cursos    
    WHERE idcurso = pidcurso;

END