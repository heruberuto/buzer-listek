<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dokumentace';
$this->params['breadcrumbs'][] = $this->title;

$doc = [
    'Popis úlohy' => [],
    'Uživatelská příručka' => [
        ''
    ]
];

function fig($src, $alt)
{
    return '<figure class="figure">
        <a href="' . $src . '" title="' . $alt . '" target="figure"><img src="' . $src . '" class="figure-img img-fluid rounded" alt="' . $alt . '"></a>
        <figcaption class="figure-caption">' . $alt . '</figcaption>
    </figure>';
}

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <h2>Zad&aacute;n&iacute;</h2>
    <p>Implementujte službu pro spr&aacute;vu <strong>buzer-l&iacute;stků</strong>. Přihl&aacute;&scaron;en&yacute;
        uživatel si na zač&aacute;tku měs&iacute;ce nastav&iacute; několik n&aacute;vyků, kter&eacute; by si za tuto
        dobu chtěl osvojit. Např.: <strong>vst&aacute;vat před osmou r&aacute;no</strong>, <strong>chodit běhat dvakr&aacute;t
            t&yacute;dně</strong>, nebo <strong>každ&yacute; den si zapsat, jak jsem ostatn&iacute; n&aacute;vyky
            plnil</strong>. Syst&eacute;m mu dle spr&aacute;vně formulovan&yacute;ch podm&iacute;nek vygeneruje aktu&aacute;ln&iacute;
        <strong>buzer-l&iacute;stek</strong>, interaktivn&iacute; tabulku, do kter&eacute; si každ&yacute; den po přihl&aacute;&scaron;en&iacute;
        z PC nebo mobilu intuitivně zap&iacute;&scaron;e např. <strong>v kolik dnes vst&aacute;val</strong>, <strong>zda
            &scaron;el dnes běhat</strong>, nebo <strong>zda dnes vyplnil l&iacute;stek včas</strong>.</p>
    <p>Tabulka m&aacute; v ř&aacute;dc&iacute;ch dny měs&iacute;ce a na sloupc&iacute;ch uživatelem nastaven&eacute; n&aacute;vyky,
        v posledn&iacute;m sloupci je automaticky <strong>Potenci&aacute;l dne</strong>.</p>
    <p>Zapsan&eacute; hodnoty, kter&eacute; vyhovuj&iacute; nastaven&eacute;mu krit&eacute;riu se označ&iacute; <strong>zelen&yacute;m </strong>smajl&iacute;kem.
        Zadan&eacute; hodnoty, kter&eacute; krit&eacute;riu nevyhovuj&iacute; se znač&iacute;
        <strong>červen&yacute;m </strong>smajl&iacute;kem. V př&iacute;padě, že nebylo možn&eacute; podm&iacute;nce dnes
        vyhovět (např. <strong>nemoc</strong>), uživatel m&aacute; možnost označit hodnotu
        <strong>modr&yacute;m</strong> smajl&iacute;kem. N&aacute;vyky, jejichž podm&iacute;nka nevyžaduje každodenn&iacute;
        plněn&iacute; (<strong>n-kr&aacute;t za t&yacute;den</strong>) a dnes jejich plněn&iacute; neproběhlo se
        <strong>pro&scaron;krt&aacute;vaj&iacute;</strong>.</p>
    <p>Do posledn&iacute;ho sloupce vypln&iacute; uživatel <strong>potenci&aacute;l dne</strong>, tedy jak byl se sv&yacute;m
        v&yacute;konem a n&aacute;ladou spokojen. Ten se označ&iacute; <strong>zelen&yacute;m </strong>smajl&iacute;kem
        pouze tehdy, jsou-li v&scaron;echny podm&iacute;nky dan&yacute; den splněny nebo nesplněny z objektivn&iacute;ch
        důvodů (<strong>modr&aacute;</strong>).</p>
    <p>Uživatel m&aacute; tak možnost sledovat jak si postupně nov&eacute; n&aacute;vyky osvojuje, jak realistick&eacute;
        na sebe měl na zač&aacute;tku n&aacute;roky a po del&scaron;&iacute; době opakov&aacute;n&iacute; n&aacute;vyků
        (obvykle <strong>měs&iacute;c</strong>) se mu st&aacute;vaj&iacute; přirozenost&iacute;.</p>
    <h3>Krit&eacute;ria splněn&iacute;</h3>
    <p>Syst&eacute;m vyhovuje definici v&yacute;&scaron;e a implementuje v&scaron;echny <strong>use-cases</strong> z
        diagramu n&iacute;že, včetně hierarchie rol&iacute;, kter&eacute; jimi disponuj&iacute;.</p>

    <?= fig(Url::to(['doc/use-case-diagram.png']), 'Use-case diagram') ?>
    <h2>Uživatelská příručka</h2>
    <h3>Popis funkčnosti webu</h3>
    <p>Členěn dle podstr&aacute;nek</p>
    <h4>&Uacute;vod</h4>
    <p><strong>Host</strong> vid&iacute; texty stručně osvětluj&iacute;c&iacute; smysl a podobu str&aacute;nek.</p>
    <p><strong>Uživatel</strong> vid&iacute; takov&yacute; svůj <strong>buzer-l&iacute;stek</strong>, kter&yacute; k dne&scaron;n&iacute;mu
        datu <strong>běž&iacute;</strong>. Pokud ž&aacute;dn&yacute; neexistuje, je přesměrov&aacute;n na <strong>m&eacute;
            buzer-l&iacute;stky</strong>. <strong>Kliknut&iacute;m</strong> do buňky ve sloupci dan&eacute;ho <strong>n&aacute;vyku</strong>
        a ř&aacute;dku dan&eacute;ho <strong>dne</strong> (např. dne&scaron;n&iacute;ho) vyvol&aacute;v&aacute; dialog
        pro vyplněn&iacute; dne&scaron;n&iacute; hodnoty. Ta se po odesl&aacute;n&iacute; <strong>Ajax</strong>em sama
        zap&iacute;&scaron;e do syst&eacute;mu a zobraz&iacute;.</p>

    <?= fig(Url::to(['doc/uvod1.png']), 'Současný buzer-lístek') ?>
    <?= fig(Url::to(['doc/uvod2.png']), 'Plnění jednoho z návyků') ?>

    <h4>O projektu, dokumentace</h4>
    <p><strong>Uživatel </strong>a <strong>host </strong>vid&iacute; statick&eacute; HTML.</p>
    <h4>M&eacute; buzer-l&iacute;stky</h4>
    <p><strong>Uživatel </strong>vid&iacute; interaktivn&iacute; tabulku v&scaron;ech
        <strong>buzer-l&iacute;stků</strong>, kter&eacute; si v syst&eacute;mu vytvořil. Může je zde <strong>přid&aacute;vat</strong>,
        <strong>upravovat</strong>, a <strong>mazat</strong>. Rovněž si může <strong>prohl&iacute;žet</strong> sv&eacute;
        ostatn&iacute; buzer-l&iacute;stky a <strong>vyplňovat</strong> jejich hodnoty.</p>
    <?= fig(Url::to(['doc/me-bl.png']), 'Mé buzer-lístky') ?>
    <h4>Upravit buzer-l&iacute;stek</h4>
    <p>Uživatel zde může napl&aacute;novan&eacute;mu <strong>buzer-l&iacute;stku</strong> nastavit data poč&aacute;tku a
        konce a předev&scaron;&iacute;m v interaktivn&iacute; tabulce spravovat <strong>n&aacute;vyky</strong>, kter&eacute;
        l&iacute;stek tvoř&iacute;. <strong>Tažen&iacute;m</strong> lze měřit jejich <strong>pořad&iacute;</strong>, tak&eacute;
        je lze <strong>upravovat, přid&aacute;vat </strong>a <strong>mazat</strong>.</p>
    <?= fig(Url::to(['doc/upravit-bl.png']), 'Úprava buzer-lístku') ?>
    <h4>Spr&aacute;va uživatel</h4>
    <p><strong>Administr&aacute;tor </strong>vid&iacute; interaktivn&iacute; tabulku v&scaron;ech
        <strong>uživatel</strong>. Zde je může <strong>mazat </strong>a <strong>upravovat</strong>. &Uacute;prava
        uživatele znač&iacute; možnou změnu jeho <strong>e-mailu </strong>a přid&aacute;n&iacute; nebo odebr&aacute;n&iacute;
        <strong>administr&aacute;torsk&yacute;ch pr&aacute;v</strong>.</p>
    <h3>Instalace a použitý software</h3>
    <p>Pr&aacute;ce běž&iacute; na <strong>yii2</strong> frameworku. Ke spr&aacute;vn&eacute;mu chodu stač&iacute; st&aacute;hnout
        repozit&aacute;ř <a title="buzer-listek" href="https://github.com/heruberuto/buzer-listek">https://github.com/heruberuto/buzer-listek</a>
        pomoc&iacute; <strong>git clone</strong> a uspokojit následující požadavky.</p>
    <p>Pro spr&aacute;vnou konfiguraci je nutn&eacute; vytvořit ve složce <strong>config</strong> soubor
        <strong>db.ini </strong>s n&aacute;sleduj&iacute;c&iacute;m obsahem:</p>

    <pre>
        dev[db] = "JMÉNO_VÝVOJOVÉ_DATABÁZE"
        dev[user] = "UŽIVATEL_VÝVOJOVÉ_DATABÁZE"
        dev[password] = "HESLO_UŽIVATELE_VÝVOJOVÉ_DATABÁZE"
        dev[host] = "HOSTITEL_VÝVOJOVÉ_DATABÁZE"

        prod[db] = "JMÉNO_PRODUKČNÍ_DATABÁZE"
        prod[user] = "UŽIVATEL_PRODUKČNÍ_DATABÁZE"
        prod[password] = "HESLO_UŽIVATELE_PRODUKČNÍ_DATABÁZE"
        prod[host] = "HOSTITEL_PRODUKČNÍ_DATABÁZE"
    </pre>
    <p>Ve Va&scaron;&iacute; datab&aacute;zi pot&eacute; importujte sch&eacute;ma spu&scaron;těn&iacute;m <strong>SQL
            předpisu </strong><a href="https://github.com/heruberuto/buzer-listek/blob/master/db.sql">https://github.com/heruberuto/buzer-listek/blob/master/db.sql</a>.
    </p>
    <p>Z&aacute;vislosti projektu jsou uvedeny v souboru <a
                href="https://github.com/heruberuto/buzer-listek/blob/master/composer.json">https://github.com/heruberuto/buzer-listek/blob/master/composer.json</a>
        a lze je automaticky nainstalovat pomoc&iacute; dependency management toolu <strong>composer</strong>.</p>
    <p>Web běž&iacute; na <strong>php7 </strong>a <strong>MySQL</strong></p>

    <h3>Databáze</h3>
    <h4>Objektově-relační model</h4>
    <?= fig(Url::to(['/doc/orm.svg']), 'Objektově-relační model') ?>
    <h4>Detailní dokumentace databáze</h4>
    <p><?= Html::a('Ve formátu PDF', ['/doc/sql-doc.pdf']) ?> </p>
    <h3>Popis implementace</h3>
    <p>Implementace dodržuje <strong>strukturu MVC</strong>. Použ&iacute;v&aacute; hotov&aacute; <strong>open-source</strong> ře&scaron;en&iacute;, zejm&eacute;na framework <strong>Yii2</strong>.</p>
    <p>Původn&iacute; k&oacute;d lze nal&eacute;zt v n&aacute;sleduj&iacute;c&iacute;ch bal&iacute;čc&iacute;ch:</p>
    <ol>
        <li><a href="https://github.com/heruberuto/buzer-listek/tree/master/components">components</a> - pomocn&eacute; komponenty, glob&aacute;lně využ&iacute;van&eacute; tř&iacute;dy</li>
        <li><a href="https://github.com/heruberuto/buzer-listek/tree/master/models">models</a> - tř&iacute;dy uchov&aacute;vaj&iacute;c&iacute; proměnn&aacute; data. <a href="https://github.com/heruberuto/buzer-listek/tree/master/models/dao">models/dao</a> jsou aktivn&iacute; z&aacute;znamy reprezentuj&iacute;c&iacute; ř&aacute;dky různ&yacute;ch tabulek v datab&aacute;zi</li>
        <li><a href="https://github.com/heruberuto/buzer-listek/tree/master/views">views</a> - HTML &scaron;ablony formalizuj&iacute;c&iacute; v&yacute;pis dat uživateli a zad&aacute;n&iacute; dat uživatelem</li>
        <li><a href="https://github.com/heruberuto/buzer-listek/tree/master/controllers">controllers</a> - cesta podstr&aacute;nky <strong>a/b</strong> je <strong>yii frameworkem</strong> ch&aacute;p&aacute;na jako vol&aacute;n&iacute; metody <strong>actionB</strong> tř&iacute;dy <strong>AController</strong> z tohoto bal&iacute;čku. Controllery tedy přiřazuj&iacute; požadavku uživatele patřičn&eacute; <strong>view</strong> a tomu dod&aacute;vaj&iacute; data př&iacute;slu&scaron;n&eacute;ho <strong>modelu</strong></li>
        <li><a href="https://github.com/heruberuto/buzer-listek/tree/master/www">www</a> - statick&yacute; obsah. Obr&aacute;zky, css a javascripty přidan&eacute; pro uživatelovo pohodl&iacute;. Aplikace tak&eacute; funguje bez nich.</li>
    </ol>
    <h4>PHPDoc dokumentace</h4>
    <?=Html::a('Vygenerována pomocí PHPDocumentoru',['/doc/phpdoc'])?>.
</div>
