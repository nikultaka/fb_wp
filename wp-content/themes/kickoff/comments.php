<?php
/**
 * The template for displaying Comments.
 */

if ( post_password_required() )
	return;
?>

<div id="kodecomments" class="kode-comments-area">
<?php if(have_comments()){ ?>
	<div class="kode-section-title"> <h2>Comments</h2> </div>
	<div class="kode-maintitle">
		<?php 
			if( get_comments_number() <= 1 ){
				echo '<h3>'.esc_attr(get_comments_number()) . ' <span class="thcolor">' . esc_html__('Recent Comments', 'kickoff').'</span></h3>'; 
			}else{
				echo '<h3>'.esc_attr(get_comments_number()) . ' <span class="thcolor">' . esc_html__('Recent Comments', 'kickoff').'</span></h3>'; 
			}
		?>	
		<div class="kode-maindivider"><span></span></div>
	</div>

	<ul class="commentlist">
		<?php wp_list_comments(array('callback' => 'kode_comment_list', 'style' => 'ul')); ?>
	</ul><!-- .commentlist -->

	<?php if (get_comment_pages_count() > 1 && get_option('page_comments')){ ?>
		<nav id="comment-nav-below" class="navigation">
			<h1 class="assistive-text section-heading"><?php echo esc_html__( 'Comment navigation', 'kickoff' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'kickoff' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'kickoff' ) ); ?></div>
		</nav>
	<?php } ?>

<?php } ?>

<?php 
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ($req ? " aria-required='true'" : '');
	
	$args = array(
		'id_form'           => 'commentform',
		'id_submit'         => 'submit',
		'title_reply'       => esc_html__('Leave a Reply', 'kickoff'),
		'title_reply_to'    => esc_html__('Leave a Reply to %s', 'kickoff'),
		'cancel_reply_link' => esc_html__('Cancel Reply', 'kickoff'),
		'label_submit'      => esc_html__('Post Comment', 'kickoff'),
		'comment_notes_before' => '',
		'comment_notes_after' => '',

		'must_log_in' => '<p class="must-log-in">' .
			sprintf( __('You must be <a href="%s">logged in</a> to post a comment.', 'kickoff'),
			esc_url(wp_login_url(apply_filters( 'the_permalink', get_permalink()))) ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' .
			sprintf( __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'kickoff'),
			esc_url(admin_url('profile.php')), $user_identity, esc_url(wp_logout_url(apply_filters('the_permalink', get_permalink( )))) ) . '</p>',

		'fields' => apply_filters('comment_form_default_fields', array(
			'author' =>
				'<p><input id="author" placeholder="' . esc_attr(esc_html__('Name*', 'kickoff')) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				'" data-default="' . esc_attr(esc_html__('Name*', 'kickoff')) . '" size="30"' . esc_attr($aria_req) . ' /></p>',
			'email' => 
				'<p><input id="email" placeholder="' . esc_attr(esc_html__('Email*', 'kickoff')) . '" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				'" data-default="' . esc_attr(esc_html__('Email*', 'kickoff')) . '" size="30"' . esc_attr($aria_req) . ' /></p>',
			'url' =>
				'<p class="full-width-kode"><input placeholder="' . esc_attr(esc_html__('Website', 'kickoff')) . '" id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) .
				'" data-default="' . esc_attr(esc_html__('Website', 'kickoff')) . '" size="30" /></p>'
		)),
		'comment_field' =>  '<p class="kode-textarea">' .
			'<textarea id="comment" placeholder="' . esc_attr(esc_html__('Comments', 'kickoff')) . '" name="comment" cols="45" rows="8" aria-required="true">' .
			'</textarea></p>'
		
	);
	comment_form($args); 

?>
</div><!-- kode-comment-area -->