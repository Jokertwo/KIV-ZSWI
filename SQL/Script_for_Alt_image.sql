
-- prvni dotaz se pokusi najit vsechny popisy obrazku a vlozit je jako
-- alternativni texty
INSERT INTO wp_postmeta -- vloz radek do tabulky wp_postmeta
	(post_id,meta_key,meta_value) -- vycet do kterych sloupcu se bude vkladat
    -- vnoreny select z dalsi tabuky, 
    SELECT ID, -- hodnota ID se vlozi do post_id
			'_wp_attachment_image_alt', -- vlozi se do sloupce meta_key 
			post_content -- vlozi se do sloupce meta_value popis pokud exituje
		FROM wp_posts -- z ktere tabulky vládam
			WHERE post_mime_type LIKE 'image/%' -- pouze obrazky
					AND
                    post_content != "   " -- post_content neni prazdny retezec
                    AND
				ID NOT IN (SELECT post_id 
									FROM wp_postmeta
                                    WHERE meta_key = '_wp_attachment_image_alt') -- image jeste nema popis
					
                    
                    ;-- ukonceni dotazu
  
  
  
  
-- druhy dotaz vezme Titulek obrazku, pokud existuje, a ulozi ho jako alternativni popis obrazku
INSERT INTO wp_postmeta -- vloz radek do tabulky wp_postmeta
	(post_id,meta_key,meta_value) -- vycet do kterych sloupcu se bude vkladat
    -- vnoreny select z dalsi tabuky, 
    SELECT ID, -- hodnota ID se vlozi do post_id
			'_wp_attachment_image_alt', -- vlozi se do sloupce meta_key 
			post_excerpt -- vlozi se do sloupce meta_value titulek pokud exituje
		FROM wp_posts -- z ktere tabulky vládam
			WHERE post_mime_type LIKE 'image/%' -- pouze obrazky
					AND
                    post_excerpt != "   " -- post_content neni prazdny retezec
                    AND
				ID NOT IN (SELECT post_id 
									FROM wp_postmeta
                                    WHERE meta_key = '_wp_attachment_image_alt') -- image jeste nema popis
					
                    
                    ;-- ukonceni dotazu
                    

-- treti dotaz vsem ostatnim obrazkum nastavi jako aletrnativni text nazev pod kterym byly nahrane
INSERT INTO wp_postmeta -- vloz radek do tabulky wp_postmeta
	(post_id,meta_key,meta_value) -- vycet do kterych sloupcu se bude vkladat
    -- vnoreny select z dalsi tabuky, 
    SELECT ID, -- hodnota ID se vlozi do post_id
			'_wp_attachment_image_alt', -- vlozi se do sloupce meta_key 
			post_title -- vlozi se do sloupce meta_value nazev pokud exituje
		FROM wp_posts -- z ktere tabulky vládam
			WHERE post_mime_type LIKE 'image/%' -- pouze obrazky
					AND
                    post_title != "   " -- post_content neni prazdny retezec
                    AND
				ID NOT IN (SELECT post_id 
									FROM wp_postmeta
                                    WHERE meta_key = '_wp_attachment_image_alt') -- image jeste nema popis
					
                    
                    ;-- ukonceni dotazu