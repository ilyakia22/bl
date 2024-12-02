<?php

/** @var yii\web\View $this */
/** @var string $content */


use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => '@web/favicon.ico']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= YANDEX_METRIKA ?>
    <?= GOOGLE_ANALYTICS ?>
    <!-- Yandex.RTB -->
    <script>
        window.yaContextCb = window.yaContextCb || []
    </script>
    <script src="https://yandex.ru/ads/system/context.js" async></script>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark']
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">

            <?php if (!empty($this->params['breadcrumbs'])) : ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>

            <!-- Yandex.RTB R-A-2583959-2 -->
            <div id="yandex_rtb_R-A-2583959-2"></div>
            <script>
                window.yaContextCb.push(() => {
                    Ya.Context.AdvManager.render({
                        "blockId": "R-A-2583959-2",
                        "renderTo": "yandex_rtb_R-A-2583959-2"
                    })
                })
            </script>

            <?= Alert::widget() ?>
            <? if (isset($this->params['h1'])) : ?>
                <h1><?= $this->params['h1'] ?></h1>
            <? endif; ?>

            <?php if (Yii::$app->session->hasFlash('success')) : ?>
                <div class="alert alert-success"><?= html_entity_decode(Yii::$app->session->getFlash('success')) ?></div>
            <? endif; ?>
            <?php if (Yii::$app->session->hasFlash('error')) : ?>
                <div class="alert alert-danger"><?= html_entity_decode(Yii::$app->session->getFlash('error')) ?></div>
            <? endif; ?>
            <?php if (Yii::$app->session->hasFlash('notice')) : ?>
                <div class="alert alert-info"><?= html_entity_decode(Yii::$app->session->getFlash('notice')) ?></div>
            <? endif; ?>

            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; ЧерноЛист.ру <?= date('Y') ?></div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
            let active = false;
            const lazyLoad = function() {
                if (active === false) {
                    active = true;
                    setTimeout(function() {
                        lazyImages.forEach(function(lazyImage) {
                            if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
                                lazyImage.src = lazyImage.dataset.src;
                                lazyImage.classList.remove("lazy");
                                lazyImages = lazyImages.filter(function(image) {
                                    return image !== lazyImage;
                                });
                                if (lazyImages.length === 0) {
                                    document.removeEventListener("scroll", lazyLoad);
                                    window.removeEventListener("resize", lazyLoad);
                                    window.removeEventListener("orientationchange", lazyLoad);
                                }
                            }
                        });
                        active = false;
                    }, 200);
                }
            };
            window.addEventListener("load", lazyLoad);
            document.addEventListener("scroll", lazyLoad);
            window.addEventListener("resize", lazyLoad);
            window.addEventListener("orientationchange", lazyLoad);
        });
    </script>
</body>

</html>
<?php $this->endPage() ?>