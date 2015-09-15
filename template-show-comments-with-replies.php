<?php

/* Template Name: Comments with Replies Report */

if( ! current_user_can( 'administrator' ) ) :
	wp_redirect( home_url() );
	echo '<script>window.location.replace("' . site_url() . '");</script>';
	exit;
endif; 

// Start the loop.
$args = array(
	'post_type' => 'post',
	'posts_per_page' => 100,
);
$comment_query = new WP_Query( $args );

?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>

		<style>
			table {
				min-width: 100%;
				font-family: sans-serif;
			}

			th, td {
				text-align: left;
				padding: 2px;
				font-size: 12px;
			}
		</style>

	</head>
	<body>
		<table>
			<tr>
				<th>Post</th>
				<th>Comment ID</th>
				<th>Comment text</th>
			</tr>
		<?php while ( $comment_query->have_posts() ) : $comment_query->the_post();
				$args = 'post_id=' . get_the_ID();
				$comments = get_comments( $args ); 
				foreach( $comments as $comment ) :
					
					$current_parent = '';

					/* Find posts with parents */
					if( $comment->comment_parent != 0 ) :

						/* Don't list the same parent content multiple times */
						if( $current_parent == $comment->comment_parent ) :
							continue;
						else :
							$current_parent = $comment->comment_parent;	
						endif;

						/* Retrieve and list parent information */
						$parent = get_comment( $current_parent );
						echo '<tr>';
							echo '<td><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></td>';
							echo '<td>' . $parent->comment_ID . '</td>';
							echo '<td>' . $parent->comment_content . '</td>';
						echo '</tr>';
					endif;
				endforeach;
		endwhile; ?>
	</body>
</html>