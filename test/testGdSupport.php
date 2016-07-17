<?php

echo "\nTesting GD support\n\n";

$pad_len = 40;
echo str_pad('GD support enabled', $pad_len);
if (function_exists("gd_info")) {
    echo "Yes\n";
    foreach (gd_info() as $k => $v) {
        echo str_pad($k, $pad_len);
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
                echo "    {$k} support is a build requirement.\n";
                exit(1);
            }
        }
    }

} else {
    echo "No\n";
    echo "    GD support is a build requirement.\n";
    exit(1);
}
exit(0);
