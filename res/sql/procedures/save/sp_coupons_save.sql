CREATE PROCEDURE sp_coupons_save(
pidcoupon INT,
pidcoupontype INT,
pdescoupon VARCHAR(128),
pdescode VARCHAR(128),
pnrqtd INT,
pnrqtdused INT,
pdtstart DATETIME,
pdtend DATETIME,
pinremoved tinyint(1),
pnrdiscount INT
)
BEGIN

    IF pidcoupon = 0 THEN
    
		INSERT INTO tb_coupons(idcoupontype, descoupon, descode, nrqtd, nrqtdused, dtstart, dtend, inremoved, nrdiscount)
        VALUES(pidcoupontype, pdescoupon, pdescode, pnrqtd, pnrqtdused, pdtstart, pdtend, pinremoved, pnrdiscount);
        
        SET pidcoupon = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_coupons SET
			idcoupontype = pidcoupontype,
            descoupon = pdescoupon,
            descode = pdescode,
			nrqtd = pnrqtd,
            nrqtdused = pnrqtdused,
            dtstart = pdtstart,
            dtend = pdtend,
            inremoved = pinremoved,
            nrdiscount = pnrdiscount
		WHERE idcoupon = pidcoupon;
	
    END IF;
    
    CALL sp_coupons_get(pidcoupon);
        
END