INSERT INTO wp_postmeta -- vloz radek do tabulky wp_postmeta
	(post_id,meta_key,meta_value) -- vycet do kterych sloupcu se bude vkladat
    -- vnoreny select z dalsi tabuky, 
    SELECT ID, -- hodnota ID se vlozi do post_id
			'_wp_attachment_image_alt', -- vlozi se do sloupce meta_key 
			post_title -- vlozi se do sloupce meta_value
		FROM wp_posts -- z ktere tabulky vládam
			WHERE post_mime_type LIKE 'image/%' AND
				ID NOT IN (SELECT post_id 
									FROM wp_postmeta
                                    WHERE meta_key = '_wp_attachment_image_alt')