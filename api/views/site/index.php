<?php
use frontend\assets\IndexAsset;
/* @var $this yii\web\View */

$this->title = '我的首页';

IndexAsset::register($this);
$this->params['breadcrumbs'][] = $this->title;
?><div class="index-box">
    <header>
        <div class="index-header-left box-style">
            <div class="content">
                <div class="content-top">
                    <span class="me">我的账户</span><span class="account">Account</span>
                </div>
                <div class="content-con">
                    <div class="content-con-img">
                        <div class="content-img-user">
                            <img src="/statics/images/app/defaultIcon.png" alt="">
                            <p><?=$model->mobile?></p>
                        </div>
                        <div class="content-img-set">
                            <img class="setIcon" src="/statics/images/app/setIcon.png" alt="">
                        </div>
                    </div>
                    <div class="content-con-money">
                        <p>账号余额</p>
                        <p class="money"><?=$model->balance?><span>条</span></p>
                    </div>
                </div>
            </div>
        </div>

<!--        <div class="index-header-right box-style">-->
<!--            <div class="content">-->
<!--                <div class="content-top">-->
<!--                    <span class="me">充值</span><span class="account">Top Up</span>-->
<!--                </div>-->
<!--                <div class="content-con">-->
<!--                    <div class="content-con-img">-->
<!--                        <div class="content-img-user">-->
<!--                            <img src="/statics/images/app/defaultIcon.png" alt="">-->
<!--                            <p>18628381293</p>-->
<!--                        </div>-->
<!--                        <div class="content-img-set">-->
<!--                            <img class="setIcon" src="/statics/images/app/setIcon.png" alt="">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="content-con-money">-->
<!--                        <p>账号余额</p>-->
<!--                        <p class="money">28,2222<span>条</span></p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        </div>-->
    </header>
<!--    <div class="index-content">-->
<!--        <div class="content-name">-->
<!--            <p><span class="cap">消费记录</span><span class="iCon">Applications</span></p>-->
<!--        </div>-->
<!--        <div class="content-table clearFix">-->
<!--            <div class="clearFix formBox">-->
<!--                <form action="">-->
<!--                    <div class="div1 li-right">-->
<!--                        <span>应用名称 :&nbsp;&nbsp;&nbsp;</span>-->
<!--                        <select name="" class="choose">-->
<!--                            <option value="">请选择</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div class="div1 li-right">-->
<!--                        <span>消费类型 :&nbsp;&nbsp;&nbsp;</span>-->
<!--                        <select name=""  class="all">-->
<!--                            <option value="">全部</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div class="div1 li-right">-->
<!--                        <span>时间查询 :&nbsp;&nbsp;&nbsp;</span>-->
<!--                        <input class="inp inp1" type="text" placeholder="开始时间">-->
<!--                        <input class="inp " type="text" placeholder="截至时间">-->
<!--                    </div>-->
<!--                    <div class="div1">-->
<!--                        <img src="/statics/images/app/searchBtn.png" alt="">-->
<!--                    </div>-->
<!--                </form>-->
<!--            </div>-->
<!--            <div class="tableData">-->
<!--                <table class="table table-striped">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th class="appName">应用名称</th>-->
<!--                        <th class="appType">消费类型</th>-->
<!--                        <th class="appNum">出入帐条数</th>-->
<!--                        <th class="appTime">时间</th>-->
<!--                        <th class="appInf">备注</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody>-->
<!--                    <tr>-->
<!--                        <td class="appName" style="border-left: 1px solid #dadada;">-->
<!--                            <span>国内短信应用</span>-->
<!--                        </td>-->
<!--                        <td class="appType" >-->
<!--                            <span>扣除</span>-->
<!--                        </td>-->
<!--                        <td class="appNum">-->
<!--                            <span>-1</span>-->
<!--                        </td>-->
<!--                        <td class="appTime" >-->
<!--                                    <span>-->
<!--                                        2017-02-10 12:32:02-->
<!--                                    </span>-->
<!--                        </td>-->
<!--                        <td class="appInf" style="border-right: 1px solid #dadada;">-->
<!--                            <span>发送扣费</span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td class="appName" style="border-left: 1px solid #dadada;">-->
<!--                            <span>国内短信应用</span>-->
<!--                        </td>-->
<!--                        <td class="appType" >-->
<!--                            <span>扣除</span>-->
<!--                        </td>-->
<!--                        <td class="appNum">-->
<!--                            <span>-1</span>-->
<!--                        </td>-->
<!--                        <td class="appTime" >-->
<!--                                    <span>-->
<!--                                        2017-02-10 12:32:02-->
<!--                                    </span>-->
<!--                        </td>-->
<!--                        <td class="appInf" style="border-right: 1px solid #dadada;">-->
<!--                            <span>发送扣费</span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td class="appName" style="border-left: 1px solid #dadada;">-->
<!--                            <span>国内短信应用</span>-->
<!--                        </td>-->
<!--                        <td class="appType" >-->
<!--                            <span>扣除</span>-->
<!--                        </td>-->
<!--                        <td class="appNum">-->
<!--                            <span>-1</span>-->
<!--                        </td>-->
<!--                        <td class="appTime" >-->
<!--                                    <span>-->
<!--                                        2017-02-10 12:32:02-->
<!--                                    </span>-->
<!--                        </td>-->
<!--                        <td class="appInf" style="border-right: 1px solid #dadada;">-->
<!--                            <span>发送扣费</span>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--            <div class="page">-->
<!--                <ul>-->
<!--                    <li class="text first">上一页</li>-->
<!--                    <li class="num">1</li>-->
<!--                    <li class="text last">下一页</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--            <div style="height: 24px"></div>-->
<!--        </div>-->
<!--        <div style="height: 134px"></div>-->
<!--    </div>-->
</div>

