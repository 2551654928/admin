<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
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
        $configs = Config::all()->whereIn('key', ['auto_detection', 'auto_writing_dateline', 'auto_writing_period']);
        $options = [];
        foreach ($configs as $config) {
            $options[$config->key] = $config->value;
        }
        // 是否开启了自动检测
        if (!$options['auto_detection']) {
            return ['code' => 0];
        }
        // TODO 检测上次与本次执行的时间
        $blogs = Blog::where('status', 1)->cursor();
        $client = new Client([
            'timeout' => 30,
            'verify' => false,
            'allow_redirects' => false,
        ]);

        $results = $datelines = $promises =[];

        foreach ($blogs as $blog) {
            $promises[] = $client->getAsync($blog->link)->then(
                function (ResponseInterface $res) {},
                function (RequestException $e) use ($blog, $options, &$results, &$datelines) {
                    Blog::where('id', $blog->id)->update(['status' => 2]);
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
                }
            );
        }

        $results = Promise\unwrap($promises);

        if (count($datelines)) {
            DB::table('dateline')->insert($datelines);
        }

        return ['code' => 1];
    }
}
