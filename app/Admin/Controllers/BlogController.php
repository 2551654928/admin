<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Blog\Send;
use App\Blog;
use App\Config;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use App\Admin\Actions\Blog\Record;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

class BlogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '博客管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Blog);
        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->column(1/2, function ($filter) {
                $filter->like('name', __('博客名称'));
                $filter->like('email', __('邮箱'));
            });
            $filter->column(1/2, function ($filter) {
                $filter->like('link', __('链接'));
                $filter->like('message', __('寄语'));
            });
        });

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', __('博客名称'))->editable()
            ->modal('大事记', function ($model) {
                $datelines = $model->datelines()->orderBy('created_at', 'desc')->get()->map(function ($dateline) {
                    return $dateline->only(['id', 'date', 'content']);
                });
                return new Table(['ID', __('记录时间'), __('内容')], $datelines->toArray());
            });
        $grid->column('avatar', __('头像'))->display(function ($avatar) {
            return '<img style="border-radius: 50%" width="20" src="'.$avatar.'">';
        });
        $grid->column('email', __('邮箱'));
        $grid->column('link', __('链接地址'))->link()
            ->copyable();
        $grid->column('message', __('寄语'))->display(function ($message) {
            return Str::limit($message, 60);
        });
        $grid->column('views', __('阅读量'))->sortable();
        $grid->column('status', __('状态'))
            ->filter(Blog::STATUS)
            ->editable('select', Blog::STATUS);
        $grid->column('is_notify', __('邮件通知'))->bool();
        $grid->column('created_at', __('提交时间'))->sortable()
            ->filter('range', 'datetime');

        $grid->actions(function ($actions) {
            $actions->add(new Record);
            $actions->add(new Send);
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Blog::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Blog);

        $form->display('id', 'ID');
        $form->text('name', __('博客名称'))
            ->rules('required|min:2');
        $form->email('email', __('邮箱'))
            ->rules('required|email')
            ->creationRules(['required', "unique:blog"])
            ->updateRules(['required', "unique:blog,email,{{id}}"]);
        $form->url('link', __('链接地址'))
            ->rules('required|url');
        $form->textarea('message', __('博主寄语'))
            ->rules('required|max:200');
        $form->radio('status', __('状态'))
            ->options(Blog::STATUS)->default(0);
        $form->text('views', __('阅读量'))->rules('numeric');

        return $form;
    }

    public function check(Content $content, Request $request)
    {
        $start = $request->input('start');
        // TODO 检测手动检测任务是否正在进行
        if ($start) {
            header('X-Accel-Buffering: no');
            $html=<<<'EOF'
<head>
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
</head>
<style>
  p {
    font-size: 15px;
    margin: 0 0 5px;
  }
  .success {
    color: green !important;
  }
  .error {
    color: red !important;
  }
</style>
<script>
  var timer = setInterval(function() {
    // 遍历异常博客
    var $errors = window.parent.$('#errors');
    $('span.error, span.end').each(function(index, item) {
        var $p = $(item).closest('p');
        if ($(item).hasClass('end')) {
            window.parent.$('#start').html('点击开始检测').attr('disabled', false);
            return clearInterval(timer);
        }
        var id = $p.attr('id');
        var name = $p.data('name');
        var link = $p.data('link');
        if ($errors.find('p#' + id).length <= 0) {
            $errors.append('<p id="' + id + '">[' + name + '][<a target="_blank" href="' + link + '">' + link + '</a>]</p>');
        }
    });
  }, 1000)
  setInterval(function() {
    // 滚动到底部
    $('body').animate({scrollTop: $('body').prop("scrollHeight")}, 1000);
  }, 3000);
</script>
EOF;
            echo $html;
            $content = ob_get_contents();
            set_time_limit(0);
            if(ob_get_length()) ob_end_clean();
            ob_implicit_flush();

            echo $content;
            $this->checkBlogOut();

            die;
        }

        return $content
            ->title('手动检测')
            ->description('手动检测博客状态')
            ->row(view('admin.check'));
    }

    private function checkBlogOut()
    {
        ignore_user_abort(0);

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
        $client = new Client([
            'timeout' => 30,
            'verify' => false,
            'allow_redirects' => false,
        ]);

        DB::beginTransaction();
        Blog::where('status', 1)->chunk(10, function ($blogs) use (&$client, &$options) {
            try {
                foreach ($blogs as $blog) {
                    $this->out("<p data-name='{$blog->name}' data-link='{$blog->link}' id='{$blog->id}'>检测博客 [{$blog->name}][<a target='_blank' href='{$blog->link}'>{$blog->link}</a>] ...");
                    $response = $client->get($blog->link);
                    if ($response->getStatusCode() == 200) {
                        $this->out("<span class='success'>√</span></p>");
                    } else {
                        // 手动检测直接列入疑似异常列表
                        $data = ['status' => 3, 'abnormal_num' => 1, 'abnormal_at' => time()];
                        if (!Blog::where('id', $blog->id)->update($data)) {
                            DB::rollBack();
                        }
                        $this->out("<span class='error'>×</span></p>");
                    }
                }

            } catch (\Exception $e) {
                $this->out("<span class='error'>×</span></p>");
            } catch (\Throwable $e) {
                $this->out("<span class='error'>×</span></p>");
            }
        });

        DB::commit();
        $this->out('<p><span class="end">end</span></p>');
    }

    private function out(...$args)
    {
        foreach ($args as $arg) {
            echo $arg;
        }
    }
}
