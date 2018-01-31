<?php
require __DIR__.'/../vendor/autoload.php';

//$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
//use App\Models\User;
//$app = require_once __DIR__.'/../bootstrap/app.php';
//User::find(1);
echo phpinfo();
//你也可以手动结束执行，保存分析结果
$xhprof_data = xhprof_disable();
$xhprof_runs = new XHProfRuns_Default();
$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");

echo '<a href="http://' . $_SERVER['HTTP_HOST'] . '/xhprof/xhprof_html/index.php?run=' . $run_id . '&source=xhprof_foo" target="_blank">性能分析</a>';