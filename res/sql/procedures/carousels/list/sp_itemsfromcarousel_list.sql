CREATE PROCEDURE sp_itemsfromcarousel_list(
pidcarousel INT
)
BEGIN

    SELECT a.*, b.destype FROM tb_carouselsitems a
        INNER JOIN tb_carouselsitemstypes b ON a.idtype = b.idtype
    WHERE a.idcarousel = pidcarousel;

END