<?php defined( 'ABSPATH' ) or exit; ?>

<div class="notice notice-info lvca-notice-rate lvca-no-image">

	<div class="lvca-notice-rate-content">

		<p><?php _e( 'Hello!', 'livemesh-vc-addons' ); ?> <?php _e( 'I see that you have the plugin <strong>Addons for WPBakery Page Builder by Livemesh</strong> installed for some time now.', 'livemesh-vc-addons' ); ?></p>
        <p><?php _e( 'If you like this plugin, please write a few words about it at wordpress.org or social media. Your opinion will help others discover our plugin.', 'livemesh-vc-addons' ); ?></p>
        <p><?php _e( 'Thank you!', 'livemesh-vc-addons' ); ?></p>

		<p class="lvca-notice-rate-actions">
			<a href="<?php echo $this->get_dismiss_link(); ?>" class="button button-primary" onclick="window.open('https://wordpress.org/support/plugin/addons-for-visual-composer/reviews/?rate=5&filter=5#new-post');"><?php _e( 'Rate plugin', 'livemesh-vc-addons' ); ?></a>
			<a href="<?php echo $this->get_dismiss_link( true ); ?>"><?php _e( 'Remind me later', 'livemesh-vc-addons' ); ?></a>
			<a href="<?php echo $this->get_dismiss_link(); ?>" class="lvca-notice-rate-dismiss"><?php _e( 'Dismiss', 'livemesh-vc-addons' ); ?></a>
		</p>

	</div>

</div>

<style>
	.lvca-notice-rate {
		position: relative;
		padding: 15px 20px;
	}
	.lvca-notice-rate .avatar {
		position: absolute;
		left: 20px;
		top: 20px;
		border-radius: 50%;
	}
	.lvca-notice-rate-content {
		margin: 0 80px;
	}
    .lvca-no-image .lvca-notice-rate-content {
        margin-left: 0;
        }
	p.lvca-notice-rate-actions {
		margin-top: 15px;
	}
	p.lvca-notice-rate-actions a {
		vertical-align: middle !important;
	}
	p.lvca-notice-rate-actions a + a {
		margin-left: 20px;
	}
	.lvca-notice-rate-dismiss {
		position: absolute;
		top: 15px;
		right: 10px;
		padding: 10px 15px 10px 21px;
		font-size: 13px;
		line-height: 1.23076923;
		text-decoration: none;
	}
	.lvca-notice-rate-dismiss:before {
		position: absolute;
		top: 8px;
		left: 0;
		margin: 0;
		-webkit-transition: all .1s ease-in-out;
		transition: all .1s ease-in-out;
		background: 0 0;
		color: #b4b9be;
		content: "\f153";
		display: block;
		font: 400 16px / 20px dashicons;
		height: 20px;
		text-align: center;
		width: 20px;
	}
	.lvca-notice-rate-dismiss:hover:before {
		color: #c00;
	}
</style>
