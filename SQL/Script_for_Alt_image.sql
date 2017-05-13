INSERT INTO wp_postmeta 
	(post_id,meta_key,meta_value)
    select ID,
			'_wp_attachment_image_alt',
			post_title
		FROM wp_posts
			WHERE post_mime_type LIKE 'image/%' and
				ID not in (select post_id 
									from wp_postmeta
                                    where meta_key = '_wp_attachment_image_alt')