<?php		
	/*global $wpdb;
	$posts_table = $wpdb->prefix."posts";											
	$special_deals = "SELECT DISTINCT wposts.ID FROM $wpdb->posts wposts WHERE wposts.ID = 10 AND wposts.post_status = 'publish'";
	$special_deals_posts = $wpdb->get_results($special_deals);
	print_r($special_deals_posts);
	//902*/
	
	$is_show_in_home_page = get_post_meta( 902, 'is_show_in_home_page', true );
	if(!empty($is_show_in_home_page) && $is_show_in_home_page == 1){
		//$url = wp_get_attachment_url( get_post_thumbnail_id(902), 'thumbnail' );
		//$special_url = get_post_meta( 902, 'special_deals_and_announcements_url', true );
		$get_template_directory_ver = esc_url( get_template_directory_uri() );
		$telephone = $get_template_directory_ver.'/img/telephone.png';	
	
?>
<!--<a class="special_deals_link" href="<?php echo ($special_url !='' ? $special_url : 'javascript:void(0)'); ?>" target="<?php echo ($special_url !='' ? '_blank' : '_self'); ?>">-->
<section id="special_deals">
	<button type="button" class="btn btn-56" data-toggle="modal" data-target="#request_callback">
		<img class="special_deals_img"  width="20" height="auto" src="<?php echo $telephone; ?>">
		<i class="icon-spin3 pending" style="display:none"></i> Request Callback
	</button>
</section><!-- End hero -->
<!--</a>-->
<style type="text/css">
  #special_deals .form-group, #special_deals label{
     margin-bottom:0 !important;
  }
  .modal-content{top:33px;}
   #sendNameMobile .form-group{
     margin-bottom:6px !important;
  }
  #special_deals p{margin: 0 0 10px;}
  #special_deals input.form-control{height:30px;}
  #special_deals .btn{margin-top:6px;}
  #special_deals .confirmMsg{
    font-weight: bold;
    font-size: 15px;
    color: #000;
    text-align: center;
    margin-top: 20px;
    }
</style>

<script type="text/javascript"> 
$(function() {
	$("#sendNameMobile input.form-control").keyup(function(e) {
		$(this).removeClass('error');
	});
});
</script>
	<?php } ?>
