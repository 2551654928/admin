<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

class TaskController extends Controller
{
    /**
     * 自动检测
     *
     * @return array
     * @throws \Throwable
     */
    public function inspect()
    {
        $configs = Config::all()->whereIn('key', [
            'auto_detection',
            'auto_writing_dateline',
            'auto_writing_period',
            'max_abnormal_num'
        ]);
        $options = [];
        foreach ($configs as $config) {
            $options[$config->key] = $config->value;
        }
        // 是否开启了自动检测
        if (!$options['auto_detection']) {
            return ['code' => 0, 'message' => '未开启自动检测'];
        }

        $cache = 'inspect_time';
        Cache::forget($cache);
        /*if (Cache::has($cache)) {
            return ['code' => 0, 'msg' => '未到下一个周期'];
        }
        Cache::put($cache, time(), (3600 * $options['auto_writing_period']));*/

        $blogs = Blog::where('status', 1)->cursor();
        $client = new Client([
            'timeout' => 30,
            'verify' => false,
            'allow_redirects' => false,
        ]);

        $results = $datelines = $promises = [];

        date_default_timezone_set('Asia/Shanghai');
        DB::beginTransaction();
        foreach ($blogs as $blog) {
            $promises[] = $client->getAsync($blog->link)->then(
                function (ResponseInterface $res) {},
                function (RequestException $e) use ($blog, $options, &$results, &$datelines) {
                    // 如果上次异常时间不在今天, 则异常次数从 1 开始, 并更新异常时间
                    if (date('Y-m-d') !== date('Y-m-d', $blog->abnormal_at)) {
                        $data = ['abnormal_num' => 1, 'abnormal_at' => time()];
                    } else {
                        $currentAbnormalNum = $blog->abnormal_num + 1;
                        // 是否已超出当天最大异常次数(加上当前异常)
                        if ($currentAbnormalNum >= $options['max_abnormal_num']) {
                            $data = ['status' => 3, 'abnormal_num' => $currentAbnormalNum, 'abnormal_at' => time()];
                            // 是否自动写入异常大事记
                            if ($options['auto_writing_dateline']) {
                                $date = date('Y-m-d H:i:s');
                                $datelines[] = [
                                    'blog_id' => $blog->id,
                                    'date' => $date,
                                    'content' => "经系统爬虫自动检测，站点发生异常无法访问(或被重定向)，标记异常({$e->getMessage()})",
                                    'updated_at' => $date,
                                    'created_at' => $date
                                ];
                            }
                        } else {
                            // 增加异常数量 and 更新异常时间
                            $data = ['abnormal_num' => $currentAbnormalNum, 'abnormal_at' => time()];
                        }
                    }
                    if (!Blog::where('id', $blog->id)->update($data)) {
                        DB::rollBack();
                    }
                }
            );
        }

        $results = Promise\unwrap($promises);

        if (count($datelines)) {
            if (!DB::table('dateline')->insert($datelines)) {
                DB::rollBack();
            }
        }

        DB::commit();

        return ['code' => 1, 'msg' => 'success'];
    }
}
