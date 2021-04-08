<?php

$apiKey = 'CUeKhra60cQHf6V6zqpmFnmKbaHi9JyXUrF6DTBmp5yhtyJAYc12';          // Ключ доступа к API
$offer_id = 1662;         // для каждого оффера свой айди, надо уточнять его в админке или у суппортов
$stream_hid = 'N2QUQx4V';     // id потока

$landKey = 'a92eaf605c89d1e328b42f5090453dd0';

$default_main_site = 'http://api.cpa.tl';
$apiSendLeadUrl = 'http://api.cpa.tl/api/lead/send_archive';
$apiGetLeadUrl = 'http://api.cpa.tl/api/lead/feed';

$dataOffers = '{"23598":{"id":23598,"name":"\u0422\u0435\u043b\u0435\u0432\u0438\u0437\u0438\u043e\u043d\u043d\u0430\u044f \u0430\u043d\u0442\u0435\u043d\u043d\u0430 HQClearTv","country":{"code":"RU","name":"\u0420\u043e\u0441\u0441\u0438\u044f"},"price":"99","price2":"1980","currency":{"code":"RUB","name":"\u0440\u0443\u0431"}}}';
$dataOffer = '{"id":23598,"name":"\u0422\u0435\u043b\u0435\u0432\u0438\u0437\u0438\u043e\u043d\u043d\u0430\u044f \u0430\u043d\u0442\u0435\u043d\u043d\u0430 HQClearTv","country":{"code":"RU","name":"\u0420\u043e\u0441\u0441\u0438\u044f"},"price":"99","price2":"1980","currency":{"code":"RUB","name":"\u0440\u0443\u0431"}}';
$is_geo_detect = '';
$productName = 'Телевизионная антенна HQClearTv';
$invoice = 'index.php';
$language = 'ru';
$push_link = '';

$keitaro_postback = '';

$companyInfo = array('address' => '603140, Нижегородская область, г. Нижний Новгород, пер. Мотальный, д. 4, офис 301', 'detail' => 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "РК-ТРЕЙД" ОГРН: 1215200002918 ИНН: 5260476009 КПП: 525801001');
$companyInfoEN = array('address' => '129090, Moscow, pereulok Zhivarev, house 8, stroenie 3, flat 16 email: ostrov.prodazh@mail.com Skype: ostrov.prodazh@mail.com', 'detail' => 'OOO "OSTROV PRODAZH" OGRN: 1197746695530 VAT: 7708365555');

$_debug = False; // установите True для вывода дополнительной информации для отладки и поиска ошибок
$pixels = [
    'fb_pixel', 'google_pixel', 'google_adw_pixel', 'tiktok_pixel', 'topmail_pixel', 'vk_pixel', 'yandex_metrika'
];

if(!$apiKey){
    echo 'Ключ доступа к API не определен. Получите в личном кабинете или обратитесь в службу поддержки';
    die;
}

if(!$offer_id){
    echo 'ID оффера не определен';
    die;
}
