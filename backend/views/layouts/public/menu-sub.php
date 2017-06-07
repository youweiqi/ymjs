<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<ul class="page-sidebar-menu  page-header-fixed hidden-sm hidden-xs" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
    <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
    <li class="sidebar-toggler-wrapper">
        <div class="media leftpanel-profile">
            <div class="media-left">
                <a href="#">
                    <img alt="" class="media-object img-circle" src="<?=Yii::getAlias('@web/statics/images/logo.png')?>" />
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><?=Yii::$app->user->identity->username?>
<!--                    <a data-toggle="collapse" data-target="#loguserinfo" class="pull-right"><i class="fa fa-angle-down"></i></a>-->
                </h4>
                <span>管理员</span>
            </div>
        </div>
<!--        <div class="leftpanel-userinfo collapse" id="loguserinfo">-->
<!--            <h5 class="sidebar-title">地址</h5>-->
<!--            <address>浙江省杭州市滨江区</address>-->
<!--            <h5 class="sidebar-title">联系方式</h5>-->
<!--            <ul class="list-group">-->
<!--                <li class="list-group-item">-->
<!--                    <label class="pull-left">邮箱</label>-->
<!--                    <span class="pull-right">me@themepixels.com</span>-->
<!--                </li>-->
<!--                <li class="list-group-item">-->
<!--                    <label class="pull-left">电话</label>-->
<!--                    <span class="pull-right">(032) 1234 567</span>-->
<!--                </li>-->
<!--                <li class="list-group-item">-->
<!--                    <label class="pull-left">手机</label>-->
<!--                    <span class="pull-right">+63012 3456 789</span>-->
<!--                </li>-->
<!--                <li class="list-group-item">-->
<!--                    <label class="pull-left">第三方</label>-->
<!--                    <div class="social-icons pull-right">-->
<!--                        <a href="#"><i class="fa fa-facebook-official"></i></a>-->
<!--                        <a href="#"><i class="fa fa-twitter"></i></a>-->
<!--                        <a href="#"><i class="fa fa-pinterest"></i></a>-->
<!--                    </div>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </div>-->
    </li>
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->

    <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
            <span></span>
        </div>
    </li>
    <!-- END SIDEBAR TOGGLER BUTTON -->

    <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
<!-- BEGIN RESPONSIVE QUICK SEARCH FORM 栏目搜索 -->
<!--    <li class="sidebar-search-wrapper">-->
<!--        -->
<!--        <form class="sidebar-search sidebar-search-bordered" action="" method="GET">-->
<!--            <a href="javascript:;" class="remove">-->
<!--                <i class="icon-close"></i>-->
<!--            </a>-->
<!--            <div class="input-group">-->
<!--                <input name="s" type="text" class="form-control" placeholder="Search...">-->
<!--                <span class="input-group-btn">-->
<!--                    <a href="javascript:;" class="btn submit">-->
<!--                        <i class="icon-magnifier"></i>-->
<!--                    </a>-->
<!--                </span>-->
<!--            </div>-->
<!--        </form>-->
<!--    </li>-->

    <?php if(!empty($allMenu['child']) && is_array($allMenu['child'])):?>
    <?php foreach ($allMenu['child'] as $menu): ?>
    <li class="nav-item  <?=$menu['active']?'open':'' ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="<?=$menu['icon']?>"></i>
            <span class="title"><?=$menu['name']?></span>
            <span class="arrow  <?=$menu['active']?'open':'' ?>"></span>
        </a>
        <ul class="sub-menu"  style="display: <?=$menu['active']?'block':'none' ?>"">
            <?php if(!empty($menu['_child']) && is_array($menu['_child'])):?>
            <?php foreach ($menu['_child'] as $v): ?>
            <li class="nav-item  <?=$v['active']?'active':'' ?> ">
                <a href="<?=\yii\helpers\Url::toRoute($v['url'])?>" nav="<?=$v['url']?>" class="nav-link ">
                    <?=$v['title']?>
                </a>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </li>
    <?php endforeach; ?>
    <?php endif; ?>
    
</ul>
<!-- END SIDEBAR MENU -->
