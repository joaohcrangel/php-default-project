CREATE PROCEDURE sp_carouselsitemstypes_remove(
pidtype INT
)
BEGIN

    DELETE FROM tb_carouselsitemstypes
    WHERE idtype = pidtype;

END