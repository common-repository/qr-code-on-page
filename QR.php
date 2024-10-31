<?php
/*
Plugin Name: QR-code on page
Plugin URI: http://webislife.ru/blog/qr-kod-na-stranitsyi-wp/
Description: Adds a page QR code for mobile devices.
Version: 1.0
Author: webislife
Author URI: http://www.webislife.ru
*/

/*
License info: GPLv2 or later.
*/


register_activation_hook(__FILE__, 'qrc_set_options');
register_deactivation_hook(__FILE__, 'qrc_unset_options');

add_action('admin_menu', 'qrc_admin_page');

$qrc_prefs_table = qrc_get_table_handle();


function qrc_get_table_handle()
{
    global $wpdb;
    return $wpdb->prefix . "qr_prefs";
}

add_action('init', 'QR_init_textdomain');
function QR_init_textdomain()
{
    load_plugin_textdomain('QR', PLUGINDIR . '/' . dirname(plugin_basename(__FILE__)) . '/lang');
}

function qrc_set_options()
{
    global $wpdb;
    add_option('qr_size', 0);
    add_option('qr_level', 0);
}

function qrc_unset_options()
{
    global $wpdb, $qrc_prefs_table;
    delete_option('qr_size');
    delete_option('qr_level');
}


function qrc_admin_page()
{
    add_options_page('qrc', __('QR-code setting', 'QR'), 8, __FILE__, 'qrc_options_page');
}

function qrc_options_page()
{
    global $wpdb, $qrc_prefs_table;

    $qrc_options = array(
        'qr_size',
        'qr_level',
    );

    $cmd = $_POST['cmd'];

    foreach ($qrc_options as $qrc_opt) {
        $$qrc_opt = get_option($qrc_opt);
    }

    if ($cmd == "qrc_save_opt") {
        foreach ($qrc_options as $qrc_opt) {
            $$qrc_opt = $_POST[$qrc_opt];
        }

        foreach ($qrc_options as $qrc_opt) {
            update_option($qrc_opt, $$qrc_opt);
        }
        ?>

    <div class="updated"><p><strong> <?php echo __('Settings saved', 'QR'); ?>
    </strong></p></div>

    <?php
    }

    ?>

<div class="wrap">

    <h2><?php echo __('QR-code on page', 'QR'); ?></h2>

    <h3><?php echo __('Settings', 'QR'); ?></h3>

    <form method="post" action="<? echo $_SERVER['REQUEST_URI'];?>">
        <table class="form-table">
            <tr>
                <th colspan=2 scope="row">
                    <select name="qr_level" style="width: 200px;">
                        <option disabled <?php if ($qr_level == '0') {
                            echo 'selected=""';
                        }?>><?php echo __('Select level', 'QR'); ?></option>
                        <option value="L" <?php if ($qr_level == 'L') {
                            echo 'selected=""';
                        }?>>L - <?php echo __('Smallest', 'QR'); ?></option>
                        <option value="M"<?php if ($qr_level == 'M') {
                            echo 'selected=""';
                        }?>>M
                        </option>
                        <option value="Q"<?php if ($qr_level == 'Q') {
                            echo 'selected=""';
                        }?>>Q
                        </option>
                        <option value="H"<?php if ($qr_level == 'H') {
                            echo 'selected=""';
                        }?>>H - <?php echo __('Best', 'QR'); ?></option>
                    </select>
                </th>
            </tr>

            <tr>
                <th colspan=2 scope="row">
                    <select name="qr_size" style="width: 200px;">
                        <option disabled="" <?php if ($qr_size == '0') {
                            echo 'selected=""';
                        }?>><?php echo __('Select size', 'QR'); ?></option>
                        <option value="1"<?php if ($qr_size == '1') {
                            echo 'selected=""';
                        }?>>1
                        </option>
                        <option value="2"<?php if ($qr_size == '2') {
                            echo 'selected=""';
                        }?>>2
                        </option>
                        <option value="3"<?php if ($qr_size == '3') {
                            echo 'selected=""';
                        }?>>3
                        </option>
                        <option value="4"<?php if ($qr_size == '4') {
                            echo 'selected=""';
                        }?>>4
                        </option>
                        <option value="5"<?php if ($qr_size == '5') {
                            echo 'selected=""';
                        }?>>5
                        </option>
                        <option value="6"<?php if ($qr_size == '6') {
                            echo 'selected=""';
                        }?>>6
                        </option>
                        <option value="7"<?php if ($qr_size == '7') {
                            echo 'selected=""';
                        }?>>7
                        </option>
                        <option value="8"<?php if ($qr_size == '8') {
                            echo 'selected=""';
                        }?>>8
                        </option>
                        <option value="9"<?php if ($qr_size == '9') {
                            echo 'selected=""';
                        }?>>9
                        </option>
                        <option value="10"<?php if ($qr_size == '10') {
                            echo 'selected=""';
                        }?>>10
                        </option>
                    </select>
                </th>
            </tr>
        </table>

        <input type="hidden" name="cmd" value="qrc_save_opt">

        <p class="submit">
            <input type="submit" name="Submit" value="<?php echo __('Save changes', 'QR'); ?>"/>
        </p>
    </form>


    <h3><?php echo __('Plugin developed', 'QR'); ?> - <a href="http://webislife.ru">webislife.ru</a></h3>
</div>

<?php
}

add_action('wp_head', QR_header);

function QR_header()
{
    ?>
<link rel="stylesheet" type="text/css" media="all"
      href="<?php echo '/' . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));?>/css/style.css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<?php
}


add_action('wp_footer', QR_footer);

function QR_footer()
{
    ?>
<link type="text/css" media="screen" href="wp-content/plugins/QR/css/style.css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery().ready(function () {
        jQuery(".QR_wrapper_left_button").click(function () {
            jQuery(".all_black").fadeIn(200);
            jQuery(".QR_wrapper").fadeIn(200);
        });
        jQuery(".QR_wrapper").click(function () {
            jQuery(".all_black").fadeOut(200);
            jQuery(".QR_wrapper").fadeOut(200);
        })
    });
</script>

<div class="QR_wrapper">
    <img
        src="<?php echo '/' . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));?>/qrgenerate.php?data=<?php bloginfo('wpurl'); echo $_SERVER['REQUEST_URI'];?>&level=<?php echo get_option('qr_level');?>&size=<?php echo get_option('qr_size');?>"
        alt="QR">
</div>
<div class="all_black"></div>
<div class="QR_wrapper_left_button"></div>

<?php
}

?>