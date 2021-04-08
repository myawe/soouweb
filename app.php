<?php
global $dir_name;
$dir_name = dirname(__FILE__);


class BeforeRenderCallback {

    private $callbacks;
    private $cwd;

    public function __construct($callbacks, $cwd=null) {
        $this->callbacks = $callbacks;
        $this->cwd = $cwd;
    }

    public function addCallback($callback) {
        $this->callbacks[] = $callback;
    }

    public function __invoke($content, $phase) {

        if ($this->cwd) {
            chdir($this->cwd);
        }

        $content = trim($content);
        foreach ($this->callbacks as $callback) {
            $content = $callback($content, $this->cwd);
        }
        return $content;
    }

    public function prepare() {
        foreach ($this->callbacks as $callback) {
            $callback->prepare();
        }
    }
}


class JsInjector {

    public $redirectUrl;
    private $code;

    public $utm = [
        "utm_source" => '',
        "utm_medium" => '',
        "utm_campaign" => '',
        "utm_content" => '',
        "utm_term" => '',

        "sub1" => '',
        "sub2" => '',
        "sub3" => '',
        "sub4" => '',
        "sub5" => '',

        'fb_pixel' => '',
        'ya_pixel' => '',
        'tiktok_pixel' => '',
        'mail_pixel' => '',
        'google_pixel' => '',
        'google_adw_pixel' => '',
        'vk_pixel' => '',
    ];

    public function __construct($params) {
        foreach($this->utm as $key => $val) {
            $this->utm[$key] = clear_value(array_get($params, $key));
        }
    }

    public function __invoke($content, $cwd) {
        $content = preg_replace('#<(?!header)head([^>])*>#',  '<head$1>' . "\n" .$this->code, $content, 1);
        return $content;
    }

    public function prepare() {
        $this->code = $this->render();
    }

    private function render() {
        incl('js.app.php', array(
            'redirectUrl' => $this->redirectUrl,
            'utm' => $this->utm,
        ));
        global $dir_name, $pixels;
        if (isset($pixels)) {
            foreach($pixels as $pixel_name) {
                if ($this->utm[$pixel_name]) {
                    $pixel_id = $this->utm[$pixel_name];
                    require_once ($dir_name.'/pieces/trackers/'.$pixel_name.'.php');
                }

            }
        }
        incl($dir_name.'/trackers.php');
    }
}

function incl($filename, $context=array()) {
    extract($context);
    global $dir_name;
    require($dir_name . '/' . $filename);
}

function countrySelect() {

    global $offers, $offer;

    usort($offers, function($a, $b) {
        return strcmp($a['country']['name'], $b['country']['name']);
    });

    ?>
    <input type="hidden" name="sub1" value="{subid}" />
    <input type="hidden" name="country" value="<?php echo $offer['country']['code']; ?>">
    <select name="offer" class="form-control country_chang">
        <?php foreach($offers as $offerData): ?>
            <option
                    data-country-code="<?php echo $offerData['country']['code'] ?>"
                <?php if ($offerData['id'] == $offer['id']): ?>
                    selected="selected"
                <?php endif ?>
                    value="<?php echo $offerData['id'] ?>"
            >
                <?php echo $offerData['country']['name'] ?>
            </option>
        <?php endforeach ?>
    </select>
    <?php
}

function countryDefault() {

    global $offer;
    ?>
    <input type="hidden" name="sub1" value="{subid}" />
    <select name="offer" class="form-control country_chang" style="display: none;">
        <option
                data-country-code="<?php echo $offer['country']['code']; ?>"
                selected="selected"
                value="<?php echo $offer['id'] ?>"
        >
            <?php echo $offer['country']['name'] ?>
        </option>
    </select>

    <?php
}


function prepaid_info_html() {
}

function footer($id=2) {
    incl("pieces/footer.{$id}.php");
}

function normalizePrice($price) {
    if (null !== $price) {
        if (intval($price) == $price) {
            $price = intval($price);
        }
    }
    return $price;
}

function clear_value($input_text){
    $input_text = strip_tags($input_text);
    $input_text = htmlspecialchars($input_text);
    return $input_text;
}

function array_get($array, $key, $default=null) {
    if (is_array($array) && array_key_exists($key, $array)) {
        return $array[$key];
    } else {
        return $default;
    }
}


function get_country($ip_address, $offers, $offer) {
    // Подключаем SxGeo.php класс
    include(__DIR__.'/geo/SxGeo.php');
    $SxGeo = new SxGeo(__DIR__.'/geo/SxGeo.dat');

    $countryDetect = $SxGeo->get($ip_address);

    return $countryDetect;
}

function get_offer_by_ip($ip_address, $offers, $offer){

    $country_code = get_country($ip_address, $offers, $offer);
    $offerDetected = $offer;
    foreach ($offers as $offerData){
        if ($offerData['country']['code'] == $country_code) {
            $offerDetected = $offerData;
        }
    }
    return $offerDetected;
}

function is_debug($set_display_error=False, $unset_cookie=False)
{
    // Проверяем включен ли debug mod
    global $_debug, $apiKey, $landKey, $dbg_mod;

    $dbg_mod = False;

    if ($_debug) {
        $dbg_mod = True;
    }

    if (isset($_GET['dbg']) && 1 == $_GET['dbg'] && isset($_GET['key']) && $apiKey == $_GET['key']) {
        $dbg_mod = True;

        // устанавливаем куку
        setcookie("dbg_hash", md5($landKey.$apiKey));
    } elseif ($unset_cookie && !$_debug) {
        setcookie("dbg_hash");
    }

    if (isset($_COOKIE['dbg_hash'])) {
        if ($_COOKIE['dbg_hash'] == md5($landKey.$apiKey)) {
            $dbg_mod = True;
        }
    }

    if ($dbg_mod and $set_display_error) {
        error_reporting(E_ALL);
        ini_set('display_startup_errors', 1);
        ini_set('display_errors', '1');
    }

    return $dbg_mod;
}

function display_debug_info($title, $data) {
    // выводит информацию об ошибках
    global $dbg_mod;
    if ($dbg_mod) {
        echo '<h3>'.$title.'</h3>';
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}