<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'O projektu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Projekt <strong>Buzer-lístek</strong> byl založen <strong><a href="http://bertik.net">Herbertem
                Ullrichem</a></strong>
        pro účely předmětu <strong><a href="https://cw.fel.cvut.cz/wiki/courses/a7b39wa1/start">Webové
                aplikace</a></strong>,
        vyučovaného <strong>Fakultě elektrotechnické, ČVUT</strong> v <strong>zimním</strong> semestru
        <strong>2017/18</strong>.
    </p>
    <p>
        Projekt jsem vytvořil na míru svým potřebám, integruje tedy například funkcionalitu pro <strong>sledování
            hmotnosti</strong>,
        která součástí původního konceptu není a je spekulativní, jestli nejde proti myšlenkovým konceptům <strong>Konce
            prokrastinace</strong>.
    </p>
    <p>
        Projekt je neziskový a jeho kód je volně dostupný na <strong><a href="http://github.com">GitHubu</a></strong>.
        Odsud je volně šiřitelný pod licencí <strong><a href="https://cs.wikipedia.org/wiki/GNU_General_Public_License">GNU
                GPL</a></strong>.
    </p>
    <h2 id="privacy-statement">Soukromí</h2>
    <p>Prohlašuji, že systém neukládá žádné osobní údaje uživatel vyjma jejich <strong>e-mailových adres</strong>. <br/>
        Ty slouží systému výhradně pro autorizaci uživatele a případné obnově účtu se zapomenutým heslem.</p>
    <p>Tvůj Buzer-lístek je čistě Tvá záležitost, nepřísluší mi ho číst. Přestože je obsah Buzer-lístku možné vyčíst z obsahu databáze,
    prohlašuji, že ji takto nevyužívám a že z prostředí této webové stránky si cizí Buzer-lístek prohlížet nelze.</p>
    <p>
        Náměty ke zlepšení a propagaci služby mi zasílejte na e-mail <strong><a
                    href="mailto:ja@bertik.net">ja@bertik.net</a></strong>.
        <br/>
        Děkuji.</p>
</div>
