<?php
/**
 * Created by WispX.
 * User: WispX <1591788658@qq.com>
 * Date: 2019/12/4
 * Time: 下午8:26 下午
 * Link: https://github.com/wisp-x
 */

/*
|--------------------------------------------------------------------------
| Gravatar Connections
|--------------------------------------------------------------------------
|
| Here are each of the Gravatar connections setup for your application.
| See https://gravatar.com/site/implement/images/ for details.
|
| Possible Keys:
|
| url           The base URL:
|                   https://secure.gravatar.com/avatar         (Default)
|                   https://gravatar.cat.net/avatar            (China Mirror)
|                   https://v2ex.assets.uxengine.net/gravatar  (China Mirror)
|
*/
function gravatar($email, $s = 96, $d = 'mp', $r = 'g', $img = false, $atts = array())
{
    preg_match_all('/((\d)*)@qq.com/', $email, $vai);
    if (empty($vai['1']['0'])) {
        $url = 'https://gravatar.cat.net/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
    } else {
        $url = 'https://q2.qlogo.cn/headimg_dl?dst_uin=' . $vai['1']['0'] . '&spec=100';
    }
    return $url;
}

/**
 * 是否进入哀悼模式(首页变灰)
 *
 * @return bool
 */
function is_mourning()
{
    date_default_timezone_set('PRC');
    ini_set('date.timezone', 'Asia/Shanghai');

    // 0404: 清明节
    // 1209: 一二·九抗日救亡运动
    // 1213: 南京大屠杀
    // 0127: 国际大屠杀纪念日
    // 0728: 唐山大地震
    // 0512: 汶川大地震

    $array = ['0404', '1209', '1213', '0127', '0728', '0512'];
    if (in_array(date('md'), $array)) {
        return true;
    }

    return false;
}
