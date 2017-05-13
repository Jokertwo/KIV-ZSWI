INSERT INTO wp_postmeta 
	(post_id,meta_key,meta_value)
    SELECT ID,
			'_wp_attachment_image_alt',
			post_title
		FROM wp_posts
			WHERE post_mime_type LIKE 'image/%' AND
				ID NOT IN (SELECT post_id 
									FROM wp_postmeta
                                    WHERE meta_key = '_wp_attachment_image_alt')