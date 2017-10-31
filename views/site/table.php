<?php
/**
 * Created by PhpStorm.
 * User: herbe
 * Date: 28.10.2017
 * Time: 23:30
 */

$this->title = 'Lístek';
$this->params['breadcrumbs'][] = $this->title;
?>
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
            <td><?= rand(0, 5) != 1 ? 'Ano' : 'Ne' ?>.</td>
            <td><?= rand(6, 8) . ':' . rand(10, 59) ?>.</td>
            <td><?= rand(0, 1) == 1 ? 'Ano' : 'Ne' ?>.</td>
            <td><?= rand(1, 10) ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
