<?php
/**
 * Mail Sender Setting Class
 *
 * @package MailSender
 */

namespace mailsender\includes\admin;

defined( 'ABSPATH' ) || exit;

/***
 * Setting Class
 */
class Setting {
	/**
	 * Message Variable
	 *
	 * @var $message
	 */
	protected $message = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Initialization
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'mail_sender_options_page' ) );
		add_action( 'admin_init', array( $this, 'send_email_to_users' ) );

	}

	/**
	 * Mail Sender Options (Select Users )
	 */
	public function mail_sender_options_page() {
		add_menu_page(
			'Mail Options',
			'Mail Options',
			'manage_options',
			'mail-options',
			array( $this, 'mail_options_page_html' )
		);
	}


	/**
	 * Register our mail_options_page to the admin_menu action hook.
	 */


	/**
	 * Top level menu callback function
	 */
	public function mail_options_page_html() {
		// check user capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		// show error/update messages.
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<h4 style="color:red">
			<?php
			echo ! is_null( $this->message ) ? esc_html( $this->message ) : '';
			?>
			</h4>
			<form action="" method="post">
				<?php
					$users = get_users();
				?>
					<label for=""><?php echo esc_html( 'Select Users' ); ?></label> <br>
					<input type="hidden" name="mail_sender_wp_nonce" id="mail_sender_wp_nonce" value="<?php echo esc_html( wp_create_nonce( 'mail_sender_wp_nonce_security' ) ); ?>">
					<select
							id="mail_users"
							name="mail_users[]" multiple="multiple" required>
						<?php
						foreach ( $users as $index => $user ) {
							?>
								<option value="<?php echo esc_html( $user->data->user_email ); ?>">
									<?php echo esc_html( $user->data->user_nicename ); ?>
								</option>
						<?php } ?>
					</select> <br>
					<label for=""><?php echo esc_html( 'Mail Title' ); ?> </label> <br>
					<input type="text" name="mail_title" id="mail_title" placeholder="You title goes here" /required> <br>
					<label for=""><?php echo esc_html( 'Body' ); ?></label> <br>
					<textarea name="mail_body" id="mail_body" cols="30" rows="10" required>
					</textarea> <br>
					<input type="submit" name="mail_submit" id = "mail_submit" value="Send Email">
			</form>
		</div>
		<?php
	}

	/**
	 * Send Email Core Function
	 */
	public function send_email_to_users() {
		if ( isset( $_POST['mail_submit'] ) && isset( $_POST['mail_sender_wp_nonce'] ) && wp_verify_nonce(
			sanitize_title( wp_unslash( $_POST['mail_sender_wp_nonce'] ) ),
			'mail_sender_wp_nonce_security'
		)
		) {
			$current_user = wp_get_current_user();
			$from         = $current_user->data->user_email;
			$header       = 'From:' . $from;
			$emails       = isset( $_POST['mail_users'] ) ? wp_unslash( $_POST['mail_users'] ) : array();

			if ( ! count( $emails ) ) {
				$this->message = 'Please select at least one user';
				return;
			}
			foreach ( $emails as $email ) {
				$to [] = sanitize_email( $email );
			}
			$subject = sanitize_title( isset( $_POST['mail_title'] ) ? wp_unslash( $_POST['mail_title'] ) : '' );
			$message = sanitize_title( isset( $_POST['mail_body'] ) ? wp_unslash( $_POST['mail_body'] ) : '' );
			if ( isset( $subject ) && isset( $message ) ) {
				$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: ' . $from );
				wp_mail( $to, $message, $message, $headers );
				$this->message = 'Email sent successfully';
			} else {
				$this->message = 'Email was not  sent';
			}
		} else {
			$this->message = 'Email was not  sent';
		}
	}
}
