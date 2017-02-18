CREATE PROCEDURE sp_itemsfromcarousel_list(
pidcarousel INT
)
BEGIN

    SELECT a.*, b.destipo FROM tb_carouselsitems a
        INNER JOIN tb_carouselsitemstipos b ON a.idtipo = b.idtipo
    WHERE a.idcarousel = pidcarousel;

END