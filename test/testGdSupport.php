<?php
if (function_exists("gd_info")) {
    echo "GD is supported\n";

    $gd = gd_info();

    foreach ($gd as $k => $v) {
        echo str_pad($k, 40);
        if ($v) {
            if (false !== stripos($k, 'version')) {
                echo "{$v}\n";
            } else {
                echo "Yes\n";
            }
        } else{
            echo "No\n";
            if (
                false !== stripos($k, 'freetype')
                || false !== stripos($k, 'gif')
                || false !== stripos($k, 'jpeg')
                || false !== stripos($k, 'png')
                || false !== stripos($k, 'wbmp')
                || false !== stripos($k, 'xpm')
                || false !== stripos($k, 'xbm')
                || false !== stripos($k, 'webp')
                || false !== stripos($k, 'jis')
            ) {
                exit(1);
            }
        }
    }

} else {
    echo "GD is NOT supported\n";
}
