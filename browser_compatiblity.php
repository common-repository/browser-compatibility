<?php
/*
  Plugin Name: Browser compatibility 
  Version: 1.0
  Plugin URI: http://www.logicbirds.com/
  Author: Mohd Rashid
  Author URI: http://www.logicbirds.com
  Description: Its provides a way to make the custom error message of the browser compatibility in a very fancy way automatically. (By default it shows at top of the page)
*/
$default = 'It seems you\'re using an unsafe, out-of-date browser.';
$sie6 = 'none';
$sie7 = 'none';
$sie8 = 'none';
$sieOpera = 'none';
$sieSafari = 'none';
$sieNs = 'none';
$sieChrome = 'none';
$sieIphone = 'none';
$siemozilla = 'none';
$resolution = '1024x768';
if (!get_option('bctext')) {
    add_option('bctext', $default);
}
if (!get_option('bc_d_ie6')) {
    add_option('bc_d_ie6', $sie6);
}
if (!get_option('bc_d_ie7')) {
    add_option('bc_d_ie7', $sie7);
}
if (!get_option('bc_d_ie8')) {
    add_option('bc_d_ie8', $sie8);
}
if (!get_option('bc_d_opera')) {
    add_option('bc_d_opera', $sieOpera);
}
if (!get_option('bc_d_safari')) {
    add_option('bc_d_safari', $sieSafari);
}
if (!get_option('bc_d_ns')) {
    add_option('bc_d_ns', $sieNs);
}
if (!get_option('bc_d_chrome')) {
    add_option('bc_d_chrome', $sieChrome);
}
if (!get_option('bc_d_mozilla')) {
    add_option('bc_d_mozilla', $siemozilla);
}
if (!get_option('resolution')) {
    add_option('resolution', $resolution);
}
if (!get_option('bc_d_iphone')) {
    add_option('bc_d_iphone', $sieIphone);
}
if (!get_option('bc_closebutton')) {
    add_option('bc_closebutton', 'yes');
}
if (!get_option('bc_bg_colour')) {
    add_option('bc_bg_colour', 'FFFFFF');
}
if (!get_option('bc_text_colour')) {
    add_option('bc_text_colour', '000000');
}

// Returns the script path
function bcPath() {
    return get_settings('home') . "/wp-content/plugins/browser_compatiblity/";
}

$thePath = bcPath();

// Options Menu
function bcMenu() {
    if (function_exists('add_options_page'))
        add_options_page(__('Browser compatibility'), __('Browser compatibility'), 'manage_options', basename(__FILE__), 'bcOptions');
}

function bcAdminHead() {
    $thePath = bcPath();
    $text_colour = get_option('bc_text_colour');
    echo '
        <style type="text/css" media="screen">
            #colourpreview { background: #f90; padding: 10px; color: #' . $text_colour . '; width: 300px; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold;}
        </style>
        <link href="' . $thePath . 'css/plugin.css" rel="stylesheet" type="text/css" />';
    echo '<script type="text/javascript" language="javascript" src="' . bcPath() . 'js/colourPicker.js"></script>';
}

function checkHex($val, $f) {
    $val = strtoupper($val);
    $val = str_replace("#", "", $val);
    $val = ereg_replace("[^0-9A-F]", $f, $val);
    $len = strlen($val);
    if ($len < 6) {
        for ($i = $len; $i < 6; $i++) {
            $val .= $f;
        }
    } else if ($len > 6) {
        $val = substr($val, 0, 6);
    }
    return $val;
}

function resolution_check() {
    if (isset($_COOKIE["users_resolution"]) && isset($_COOKIE["res_width"]) && isset($_COOKIE["res_height"])) {
        $screen_resolution = $_COOKIE["users_resolution"];
        $screen_width = $_COOKIE["res_width"];
        $screen_height = $_COOKIE["res_height"];
        return $screen_resolution;
    } else { //means cookie is not found set it using Javascript
        ?>
        <script language="javascript">
            Set_Cookie('users_resolution', screen.width + "x" + screen.height, 0.05); // for 5 second
            Set_Cookie('res_width', screen.width, 0.05);
            Set_Cookie('res_height', screen.height, 0.05);
            function Set_Cookie(name, value, expires, path, domain, secure) {
                // set time, it's in milliseconds
                var today = new Date();
                today.setTime(today.getTime());
                // if the expires variable is set, make the correct expires time, the
                // current script below will set it for x number of days, to make it
                // for hours, delete * 24, for minutes, delete * 60 * 24
                if (expires)
                {
                    //expires = expires * 1000 * 60 * 60 * 24;
                    expires = expires * 1000 * 60;
                }
                //alert( 'today ' + today.toGMTString() );// this is for testing purpose only
                var expires_date = new Date(today.getTime() + (expires));
                //alert('expires ' + expires_date.toGMTString());// this is for testing purposes only

                document.cookie = name + "=" + escape(value) +
                        ((expires) ? ";expires=" + expires_date.toGMTString() : "") + //expires.toGMTString()
                        ((path) ? ";path=" + path : "") +
                        ((domain) ? ";domain=" + domain : "") +
                        ((secure) ? ";secure" : "");
            }
            document.location.href = ''
        </script>
        <?php
        if (!get_option('bc_swidth')) {
            add_option('bc_swidth', $_COOKIE["res_width"]);
        }
        if (!get_option('bc_sheight')) {
            add_option('bc_sheight', $_COOKIE["res_height"]);
        }
    }
}

// Options Administration
function bcOptions() {
    if ($_POST["submit"]) {
        $newtext = $_POST["bannertext"];
        update_option('bctext', $newtext);

        if ($_POST["display_six"] == 'ie6') {
            update_option('bc_d_ie6', 'none');
        } else {
            update_option('bc_d_ie6', 'block');
        }
        if ($_POST["display_seven"] == 'ie7') {
            update_option('bc_d_ie7', 'none');
        } else {
            update_option('bc_d_ie7', 'block');
        }
        if ($_POST["display_eight"] == 'ie8') {
            update_option('bc_d_ie8', 'none');
        } else {
            update_option('bc_d_ie8', 'block');
        }
        if ($_POST["display_opera"] == 'opera') {
            update_option('bc_d_opera', 'none');
        } else {
            update_option('bc_d_opera', 'block');
        }
        if ($_POST["display_safari"] == 'safari') {
            update_option('bc_d_safari', 'none');
        } else {
            update_option('bc_d_safari', 'block');
        }

        if ($_POST["display_ns"] == 'ns') {
            update_option('bc_d_ns', 'none');
        } else {
            update_option('bc_d_ns', 'block');
        }
        if ($_POST["display_chrome"] == 'chrome') {
            update_option('bc_d_chrome', 'none');
        } else {
            update_option('bc_d_chrome', 'block');
        }
        if ($_POST["display_mozilla"] == 'mozilla') {
            update_option('bc_d_mozilla', 'none');
        } else {
            update_option('bc_d_mozilla', 'block');
        }
        if ($_POST["display_iphone"] == 'iphone') {
            update_option('bc_d_iphone', 'none');
        } else {
            update_option('bc_d_iphone', 'block');
        }

        if ($_POST["display_resolution"] == '1024x768') {
            update_option('resolution', '1024x768');
        } else {
            update_option('resolution', $_POST['display_resolution']);
        }

        $position = strpos($_POST["display_resolution"], 'x');
        $width_string = substr($_POST["display_resolution"], 0, $position);
        $width_int = $width_string + 0;
        $height_string = substr($_POST["display_resolution"], $position + 1);
        $height_int = $height_string + 0;
        update_option('bc_swidth', $width_int);
        update_option('bc_sheight', $height_int);


        if ($_POST["closebutton"] == 'close') {
            update_option('bc_closebutton', 'yes');
        } else {
            update_option('bc_closebutton', 'no');
        }

        $bg_col = checkHex($_POST["bg_colour"], 'F');
        update_option('bc_bg_colour', $bg_col);

        $text_col = checkHex($_POST["text_colour"], '0');
        update_option('bc_text_colour', $text_col);


        $msgSaved = "Options Saved";
    }
    $thePath = bcPath();
    if ($msgSaved) {
        echo '<!-- Last Action --><div id="message" class="updated fade"><p>' . $msgSaved . '</p></div>';
    }

    $ie6_checked = get_option('bc_d_ie6');
    if ($ie6_checked == 'none') {
        $tick6 = 'checked="yes"';
    } else {
        $tick6 = '';
    }

    $ie7_checked = get_option('bc_d_ie7');
    if ($ie7_checked == 'none') {
        $tick7 = 'checked="yes"';
    } else {
        $tick7 = '';
    }

    $ie8_checked = get_option('bc_d_ie8');
    if ($ie8_checked == 'none') {
        $tick8 = 'checked="yes"';
    } else {
        $tick8 = '';
    }

    $opera_checked = get_option('bc_d_opera');
    if ($opera_checked == 'none') {
        $tickopera = 'checked="yes"';
    } else {
        $tickopera = '';
    }

    $safari_checked = get_option('bc_d_safari');
    if ($safari_checked == 'none') {
        $ticksafari = 'checked="yes"';
    } else {
        $ticksafari = '';
    }

    $ns_checked = get_option('bc_d_ns');
    if ($ns_checked == 'none') {
        $tickns = 'checked="yes"';
    } else {
        $tickns = '';
    }
    $chrome_checked = get_option('bc_d_chrome');
    if ($chrome_checked == 'none') {
        $tickchrome = 'checked="yes"';
    } else {
        $tickchrome = '';
    }
    $mozilla_checked = get_option('bc_d_mozilla');
    if ($mozilla_checked == 'none') {
        $tickmozilla = 'checked="yes"';
    } else {
        $tickmozilla = '';
    }

    $iphone_checked = get_option('bc_d_iphone');
    if ($iphone_checked == 'none') {
        $tickiphone = 'checked="yes"';
    } else {
        $tickiphone = '';
    }

    $close_checked = get_option('bc_closebutton');
    if ($close_checked == 'yes') {
        $tickc = 'checked="yes"';
    } else {
        $tickc = '';
    }

    $bg_colour = get_option('bc_bg_colour');
    $text_colour = get_option('bc_text_colour');
    ?>
    <div class="wrap" id="bcbox">
        <h2><?php _e('"Browser compatibility'); ?></h2>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
    <?php wp_nonce_field('update-options') ?>
            <p>Enter the customize Error massage which will display on your depreciated browser.</p>
            <div style="margin: 20px 0px;">
                <div class="fifty-left">
                    <h3>Error massage</h3>
                    <textarea name="bannertext" cols="50" rows="3" style="width: 400px;"><?php echo stripslashes(get_option('bctext')) ?></textarea>
                    <h3>Display Settings</h3>
                    <select name="display_resolution" id="display_resolution">
                        <option>- Please select the screen resolution -</option>
                        <option value="544x378" <?php if (get_option('resolution') == '544x378') echo 'selected="selected"' ?>>544 x 378 (WebTV)</option>
                        <option value="640x480" <?php if (get_option('resolution') == '640x480') echo 'selected="selected"' ?>>640 x 480</option>
                        <option value="800x600" <?php if (get_option('resolution') == '800x600') echo 'selected="selected"' ?>>800 x 600</option>
                        <option value="832x624" <?php if (get_option('resolution') == '832x624') echo 'selected="selected"' ?>>832 x 624</option>
                        <option value="1024x768" <?php if (get_option('resolution') == '1024x768') echo 'selected="selected"' ?>>1024 x 768</option>
                        <option value="1152x864" <?php if (get_option('resolution') == '1152x864') echo 'selected="selected"' ?>>1152 x 864</option>
                        <option value="1280x800" <?php if (get_option('resolution') == '1280x800') echo 'selected="selected"' ?>>1280 x 800</option>
                        <option value="1280x1024" <?php if (get_option('resolution') == '1280x1024') echo 'selected="selected"' ?>>1280 x 1024</option>
                        <option value="1366x768" <?php if (get_option('resolution') == '1366x768') echo 'selected="selected"' ?>>1366 x 768</option>
                        <option value="1440x900" <?php if (get_option('resolution') == '1440x900') echo 'selected="selected"' ?>>1440 x 900</option>
                        <option value="1680x1050" <?php if (get_option('resolution') == '1680x1050') echo 'selected="selected"' ?>>1680 x 1050</option>
                        <option value="1920x1200" <?php if (get_option('resolution') == '1920x1200') echo 'selected="selected"' ?>>1920 x 1200</option>
                    </select>
                </div>
                <div class="fifty-right">
                    <h3>Compatibility Settings:</h3>
                    Please select the following browsers which is Compatible with your template.
                    <div>
                        <input type="checkbox" name="display_six" value="ie6" <?php echo $tick6; ?> />IE6
                    </div>
                    <div>
                        <input type="checkbox" name="display_seven" value="ie7" <?php echo $tick7; ?> />IE7
                    </div>
                    <div>
                        <input type="checkbox" name="display_eight" value="ie8" <?php echo $tick8; ?> />IE8
                    </div>
                    <div>
                        <input type="checkbox" name="display_opera" value="opera" <?php echo $tickopera; ?> />Opera
                    </div>
                    <div>
                        <input type="checkbox" name="display_safari" value="safari" <?php echo $ticksafari; ?> />Safari
                    </div>
                    <div>
                        <input type="checkbox" name="display_ns" value="ns" <?php echo $tickns; ?> />Netscape navigator (NS)
                    </div>
                    <div>
                        <input type="checkbox" name="display_chrome" value="chrome" <?php echo $tickchrome; ?> />Chrome
                    </div>

                    <div>
                        <input type="checkbox" name="display_mozilla" value="mozilla" <?php echo $tickmozilla; ?> />Mozilla
                    </div>

                    <div>
                        <input type="checkbox" name="display_iphone" value="iphone" <?php echo $tickchrome; ?> />I-Phone
                    </div>

                    <div style="margin-top: 10px;">
                        <input type="checkbox" name="closebutton" value="close" <?php echo $tickc; ?> /> Show 'Close' X Button <small>(Allows the user to close the banner)</small>
                    </div>
                </div>
                <div class="killbth"></div>
            </div>
            <div style="margin: 20px 0px;">
                <div class="fifty-left">
                    <h3>Banner Colours:</h3>
                    <div style="margin-bottom: 5px; ">
                        #<input type="text" class="textinput" name="bg_colour" id="bg_colour" value="<?php echo $bg_colour; ?>" /> : Background Colour <small>(default is white #FFFFFF)</small> <img src="<?php echo $thePath; ?>media/wheel.gif" onmousedown="setPicker('cptext');" alt="Open Colour Picker" />
                    </div>
                    <div style="margin-bottom: 20px; font-weight: bold; color: #000066;" onClick="noBG();">
                        Click to Remove Background
                    </div>
                    <div>
                        #<input type="text" class="textinput" name="text_colour" id="text_colour" value="<?php echo $text_colour; ?>" /> : Text Colour <small>(default is black #000000)</small> <img src="<?php echo $thePath; ?>media/wheel.gif" onmousedown="setPicker('colourpreview');" alt="Open Colour Picker" />
                    </div>
                </div>
                <div class="fifty-right">
                    <h3>Colours Preview:</h3>
                    <div id="colourpreview" style="colour: #<?php echo $text_colour; ?> !important;">
                        <p id="cptext" style="background: #<?php echo $bg_colour; ?>;">Here is some example text to give you and idea of what your text will look like.</p>
                    </div>
                </div>
                <div class="killbth"></div>

                </p>
            </div>
            <div style="margin-bottom:10px;">
                <input type="hidden" name="page_options" value="bannertext,display_six,display_seven,closebutton,bg_colour,text_colour" />
                <p class="submit">
                    <input type="submit" name="submit" value="<?php _e('Update Options &raquo;'); ?>" />
            </div>
        </form>
    </div>
    <!-- Colour Picker Plugin -->
    <div id="plugin" style="Z-INDEX: 20; display: none;">
        <div id="plugCUR"></div><div id="plugHEX" onmousedown="stop = 0;
            setTimeout('stop=1', 100);">FFFFFF</div> <div class="plugCLOSE" onmousedown="toggle('plugin');" style="color: #fff !important; float: right;">X</div><br>
        <div id="SV" onmousedown="HSVslide('SVslide', 'plugin', event)" title="Saturation + Value">
            <div id="SVslide" style="TOP: -4px; LEFT: -4px;"><br /></div>
        </div>
        <form id="H" onmousedown="HSVslide('Hslide', 'plugin', event)" title="Hue">
            <div id="Hslide" style="TOP: -7px; LEFT: -8px;"><br /></div>
            <div id="Hmodel"></div>
        </form>
    </div>
    <script type="text/javascript">
        loadSV();
        $S('plugin').display = 'none';
        $S('SVslide').top = (80 / 100 * 170 - 7) + 'px';
    //HSVupdate([20,0,20]);
    </script>
    <!-- Colour Picker Plugin -->
    <?php
}

// Add CSS to header
function bcHeader() {
//echo get_option('home').'/wp-content/plugins/get_browser_compatiblity/close.png';
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    $screen_resolution = resolution_check();
    $thePath = bcPath();
    $state_6 = get_option('bc_d_ie6');
    $state_7 = get_option('bc_d_ie7');
    $state_8 = get_option('bc_d_ie8');
    $state_opera = get_option('bc_d_opera');
    $state_safari = get_option('bc_d_safari');
    $state_safari = get_option('bc_d_ns');
    $state_safari = get_option('bc_d_chrome');
    $state_safari = get_option('bc_d_iphone');
    $state_mozilla = get_option('bc_d_mozilla');
    $bg_colour = get_option('bc_bg_colour');
    if ($bg_colour == 'FF9900') {
        $bg_colour = 'none';
    } else {
        $bg_colour = '#' . $bg_colour;
    }
    $text_colour = get_option('bc_text_colour');

    if ($_COOKIE["users_resolution"] != get_option('resolution')) {
        $state_6 = 'block';
    }
    if ($_COOKIE["users_resolution"] != get_option('resolution')) {
        $state_7 = 'block';
    }
    if ($_COOKIE["users_resolution"] != get_option('resolution')) {
        $state_8 = 'block';
    }

    echo '<style type="text/css" media="screen">
                #chk_brwsr_compat {display: none; background: #f90 url("' . $thePath . 'media/background_image.jpg") no-repeat center top; position: absolute; width: 100% !important; padding: 10px 0px; text-align: center; top: 0; left: 0; color: #' . $text_colour . '; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; z-index: 99; }
                #chk_brwsr_compat p { margin: 0 !important; padding: 5px; background: ' . $bg_colour . '; display: inline; }
                #chk_brwsr_compat a { color: #' . $text_colour . '; border: none !important; text-decoration: underline; }
                #chk_brwsr_compat a:hover { color: #f00; }
                #chk_brwsr_compat { display /*\**/: ' . $state_8 . '\9; }
                *:first-child+html #chk_brwsr_compat { display: ' . $state_7 . '; }
                * html #chk_brwsr_compat { display: ' . $state_6 . '; }
         </style>
         <script type="text/javascript" language="javascript" src="' . bcPath() . 'js/hideBanner.js"></script>';

    /* For opera */
    if ($is_opera) {
        if ((get_option('bc_d_opera') == 'block') || ((get_option('bc_swidth') >= $_COOKIE["res_width"]) && (get_option('bc_sheight') > $_COOKIE["res_height"]))) {
            echo '
            <style type="text/css" media="screen">
                #chk_brwsr_compat {display: block; background: #f90 url("' . $thePath . 'media/background_image.jpg") no-repeat center top; position: absolute; width: 100% !important; padding: 10px 0px; text-align: center; top: 0; left: 0; color: #' . $text_colour . '; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; z-index: 99; }
            </style>';
        }
    }
    /* For safari */
    if ($is_safari) {

        if ((get_option('bc_d_safari') == 'block') || ((get_option('bc_swidth') >= $_COOKIE["res_width"]) && (get_option('bc_sheight') > $_COOKIE["res_height"]))) {
            echo '<style type="text/css" media="screen">
                    #chk_brwsr_compat {display: block; background: #f90 url("' . $thePath . 'media/background_image.jpg") no-repeat center top; position: absolute; width: 100% !important; padding: 10px 0px; text-align: center; top: 0; left: 0; color: #' . $text_colour . '; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; z-index: 99; }
                 </style>';
        }
    }
    /* For Netscape navigator */
    if ($is_NS4) {
        if ((get_option('bc_d_ns') == 'block') || ((get_option('bc_swidth') >= $_COOKIE["res_width"]) && (get_option('bc_sheight') > $_COOKIE["res_height"]))) {
            echo '<style type="text/css" media="screen">
                    #chk_brwsr_compat {display: block; background: #f90 url("' . $thePath . 'media/background_image.jpg") no-repeat center top; position: absolute; width: 100% !important; padding: 10px 0px; text-align: center; top: 0; left: 0; color: #' . $text_colour . '; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; z-index: 99; }
                  </style>';
        }
    }
    /* For Google chrome */
    if ($is_chrome) {
        if ((get_option('bc_d_chrome') == 'block') || ((get_option('bc_swidth') >= $_COOKIE["res_width"]) && (get_option('bc_sheight') > $_COOKIE["res_height"]))) {
            echo '<style type="text/css" media="screen">
                    #chk_brwsr_compat {display: block; background: #f90 url("' . $thePath . 'media/background_image.jpg") no-repeat center top; position: absolute; width: 100% !important; padding: 10px 0px; text-align: center; top: 0; left: 0; color: #' . $text_colour . '; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; z-index: 99; }
                  </style>';
        }
    }
    /* For Mobile browser Iphone */
    if ($is_iphone) {
        if ((get_option('bc_d_iphone') == 'block') || ((get_option('bc_swidth') >= $_COOKIE["res_width"]) && (get_option('bc_sheight') > $_COOKIE["res_height"]))) {
            echo '<style type="text/css" media="screen">
                    #chk_brwsr_compat {display: block; background: #f90 url("' . $thePath . 'media/background_image.jpg") no-repeat center top; position: absolute; width: 100% !important; padding: 10px 0px; text-align: center; top: 0; left: 0; color: #' . $text_colour . '; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; z-index: 99; }
                  </style>';
        }
    }
   
    /* For Mozilla */

    if ($is_gecko) {
        if ((get_option('bc_d_mozilla') == 'block') || ((get_option('bc_swidth') >= $_COOKIE["res_width"]) && (get_option('bc_sheight') > $_COOKIE["res_height"]))) {
            echo '<style type="text/css" media="screen">
                    #chk_brwsr_compat {display: block; background: #f90 url("' . $thePath . 'media/background_image.jpg") no-repeat center top; position: absolute; width: 100% !important; padding: 10px 0px; text-align: center; top: 0; left: 0; color: #' . $text_colour . '; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; z-index: 99; }
                  </style>';
        }
    }
    ?>

    <!--  This Following Div code of id->chk_brwsr_compat is used where you want to display this browser compatibility massage-->	
    <div id="chk_brwsr_compat">
        <p> <?php echo display_compatibility_massage() ?> </p>
    </div>
    <?php
}

// Call this function where you want to display this massage
function display_compatibility_massage() {
    $dispaly_msg = '';
    $text = get_option('bctext');
    $text = stripslashes($text);
    $dispaly_msg .= $text;
    if (get_option('bc_closebutton') == 'yes') {
        $dispaly_msg .= '&nbsp;<a href="#" title="CLOSE Banner" onClick="javascript:hideBanner();">CLOSE(X)</a>';
    }
    return $dispaly_msg;
}
// Add Actions
add_action('admin_menu', 'bcMenu');
add_action('admin_head', 'bcAdminHead');
add_action('wp_head', 'bcHeader');
add_action('wp_footer', 'display_compatibility_massage');
?>