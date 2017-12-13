<?php
/**
 * Created by PhpStorm.
 * User: herbe
 * Date: 28.10.2017
 * Time: 23:30
 */

use yii\helpers\Url;

$this->title = 'Lístek';
$this->params['fullWidth'] = true;
?>
<div class="jumbotron">
    <div class="container">
        <h1 class="display-3">Vítej!</h1>
        <p class="lead">Bla bla.</p>
        <!--p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p-->
    </div>
</div>
<div class="container">
    <table class="table table-striped table-bordered">
        <thead class="thead-light">
        <tr>
            <th>Den</th>
            <th>Todo today</th>
            <th>Vstávání</th>
            <th>Cvičení</th>
            <th>Potenciál dne</th>
        </tr>
        <tr>
            <td>-</td>
            <td>Na zítra</td>
            <td>< 7:30</td>
            <td>3x týdně</td>
            <td>1..10</td>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i = 1; $i <= 31; $i++) {
            ?>
            <tr>
                <td><?= $i ?>.</td>
                <td>
                    <?= rand(0, 5) != 1 ? 'Ano' : 'Ne' ?>
                    <img src="<?= Url::to(['/images/smile.svg']) ?>" class="emoticon">
                </td>
                <td><?= rand(6, 8) . ':' . rand(10, 59) ?></td>
                <td><?= rand(0, 1) == 1 ? 'Ano' : 'Ne' ?></td>
                <td><?= rand(1, 10) ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
