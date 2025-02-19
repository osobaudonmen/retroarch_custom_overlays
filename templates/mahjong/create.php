<?php

$tmpl = file_get_contents(__DIR__ . '/mahjong.tmpl');

$games = [
    'mjkjidai' => [1, 0.1430, 0.0518, 0.91, 0, 0.027, 0.09, 0.835],
    'janjans1' => [1, 0.0600, 0.0650, 0.89, 0, 0.034, 0.11, 0.939],
    'mj4simai' => [1, 0.0720, 0.0650, 0.89, 0, 0.034, 0.11, 0.939],
    'mjnquest' => [1, 0.1505, 0.0500, 0.91, 0, 0.026, 0.09, 0.850],
];

foreach ($games as $name => $pos) {
    $overlay = createOverlay(...$pos);
    foreach (
        [
        ''     => ['retrok_space', 'retrok_alt', 'retrok_ctrl', 'retrok_shift'],
        '_alt' => ['retrok_left', 'retrok_down', 'retrok_right', 'retrok_up'],
        ] as $suffix => $keyMap
    ) {
        $cfg = str_replace(
            ['%KEY_CHI%', '%KEY_PON%', '%KEY_KAN%', '%KEY_REACH%', '%OVERLAY%'],
            [...$keyMap, $overlay],
            $tmpl
        );
        $file = "mahjong_$name$suffix.cfg";
        echo "$file\n";
        file_put_contents($file, $cfg);
    }
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
            $i === 13 ? $nx : $ox + $dx * $i,
            $oy + $dy * $i,
            $w,
            $h
        );
    }
    return $text;
}
