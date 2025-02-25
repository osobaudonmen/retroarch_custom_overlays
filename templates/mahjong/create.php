<?php

$keyMap = match ($argv[1] ?? null) {
    'arrow_keys' => ['retrok_left', 'retrok_down', 'retrok_right', 'retrok_up'],
    default      => ['retrok_space', 'retrok_alt', 'retrok_ctrl', 'retrok_shift'],
};
printf("chi, pon, kan reach = %s\n", implode(', ', $keyMap));

$isDebug = 'debug' === ($argv[2] ?? null);
printf("debug = %s\n", $isDebug ? 'true' : 'false');

$tmpl = file_get_contents(__DIR__ . '/mahjong.tmpl');

$games = [
    'akiss'    => [1, 0.1240, 0.0595, 0.90, 0, 0.030, 0.10, 0.920],
    'bnstars1' => [1, 0.0810, 0.0624, 0.89, 0, 0.033, 0.11, 0.917],
    'cdsteljn' => [1, 0.0640, 0.0668, 0.89, 0, 0.033, 0.05, 0],
    'cultures' => [1, 0.0720, 0.0624, 0.89, 0, 0.033, 0.11, 0.927],
    'ejanhs'   => [1, 0.0850, 0.0624, 0.89, 0, 0.033, 0.11, 0.927],
    'hotgmck'  => [1, 0.0630, 0.0654, 0.89, 0, 0.034, 0.11, 0.939],
    // 'hypreact' => [1, 0.0890, 0.0624, 0.88, 0, 0.033, 0,    0.920], // has joystick mode
    // 'hypreac2' => [1, 0.0520, 0.0620, 0.91, 0, 0.030, 0,    0.870], // has joystick mode
    'janjans1' => [1, 0.0600, 0.0650, 0.89, 0, 0.034, 0.11, 0.939],
    'janjans2' => [1, 0.0640, 0.0654, 0.89, 0, 0.034, 0.11, 0.939],
    'jongpute' => [1, 0.0600, 0.0625, 0.91, 0, 0.032, 0,    0.885],
    'kirarast' => [1, 0.0810, 0.0624, 0.90, 0, 0.033, 0,    0.917],
    'cdsteljn' => [1, 0.0640, 0.0668, 0.89, 0, 0.033, 0.05, 0],
    'mgakuen'  => [1, 0.0720, 0.0624, 0.91, 0, 0.033, 0.09, 0.907],
    'mirage'   => [1, 0.0780, 0.0624, 0.90, 0, 0.033, 0,    0.927],
    'mj4simai' => [1, 0.0720, 0.0650, 0.89, 0, 0.034, 0.11, 0.939],
    'mjkjidai' => [1, 0.1430, 0.0518, 0.91, 0, 0.027, 0.09, 0.835],
    'mjnquest' => [1, 0.1505, 0.0500, 0.91, 0, 0.026, 0.09, 0.850],
    'srmp4'    => [1, 0.1000, 0.0625, 0.90, 0, 0.032, 0,    0.938],
    'srmp7'    => [1, 0.0780, 0.0595, 0.88, 0, 0.030, 0.09, 0.875],
    'suchie2'  => [1, 0.0560, 0.0625, 0.91, 0, 0.031, 0,    0.945],

    '4psimasy' => [1, 0.09266826923076922, 0.06241987179487179, 0.9097222222222222, 0, 0.031209935897435894, 0.07361111111111111, 0.9041266025641026],
    '7jigen'   => [1, 0.040705128205128206, 0.06682692307692309, 0.8881944444444444, 0, 0.033413461538461545, 0.09930555555555555, 0.9292467948717948],
    'akamj'    => [1, 0.06233974358974359, 0.06217948717948718, 0.9215277777777777, 0, 0.03108974358974359, 0.07013888888888889, 0.8894230769230769],
    'apparel'  => [1, 0.13092376373626374, 0.05425824175824175, 0.9122023809523809, 0, 0.027129120879120876, 0.0818452380952381, 0.8664148351648351],
    'av2mj1bb' => [1, 0.056290064102564104, 0.0625801282051282, 0.9006944444444445, 0, 0.0312900641025641, 0.08819444444444445, 0.9052483974358975],
    'av2mj2rg' => [1, 0.08024839743589744, 0.0625801282051282, 0.8548611111111111, 0, 0.0312900641025641, 0.11736111111111111, 0.9364983974358975],
    'bijokkog' => [1, 0.04766600920447074, 0.06684198991891299, 0.926270136307311, 0, 0.033420994959456496, 0.0563816604708798, 0.947950909489371],
    'kiwame'   => [1, 0.17992788461538461, 0.05360576923076923, 0.9104166666666667, 0, 0.026802884615384614, 0.07430555555555556, 0.885136217948718],
    'yujan'    => [1, 0.07256628876604516, 0.062306755364002625, 0.8887987012987013, 0, 0.031153377682001313, 0.07711038961038962, 0.9056966176332802],
    'vanilla'  => [1, 0.05520833333333333, 0.0625, 0.9159722222222222, 0, 0.03125, 0.07013888888888889, 0.90625],
    'psailor1' => [1, 0.052043269230769226, 0.06866987179487179, 0.8736111111111111, 0, 0.03433493589743589, 0.1111111111111111, 0.9447516025641025],
    'dokyusei' => [1, 0.08143028846153845, 0.062414148351648345, 0.8824404761904762, 0, 0.031207074175824173, 0.08333333333333333, 0.9173677884615384],
];

foreach ($games as $name => $pos) {
    $overlay = createOverlay(...$pos);
    $cfg = str_replace(
        ['%KEY_CHI%', '%KEY_PON%', '%KEY_KAN%', '%KEY_REACH%', '%OVERLAY%'],
        [...$keyMap, $overlay],
        $tmpl
    );
    if (!$isDebug) {
        $cfg = preg_replace('/### BEGIN DEBUG.+?### END DEBUG/s', '', $cfg);
    }

    $file = "mahjong_$name.cfg";
    echo "$file\n";
    file_put_contents($file, $cfg);
}

function createOverlay($n, $ox, $dx, $oy, $dy, $w, $h, $nx)
{
    $text = '';
    for ($i = 0; $i < 14; $i++) {
        $text .= sprintf(
            "overlay%d_desc%d = \"retrok_%s,%0.6f,%0.6f,rect,%0.6f,%0.6f\"\n",
            $n,
            $i,
            chr(ord('a') + $i),
            $i === 13 && $nx !== 0 ? $nx : $ox + $dx * $i,
            $oy + $dy * $i,
            $w,
            $h === 0 ? 1.0 - $oy : $h
        );
    }
    return $text;
}
