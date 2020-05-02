<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<h1>Получение данных, используя XML </h1>
<section>
    <?php if ($arResult['ERROR']): ?>
        <span>Произошла ошибка попробуйте позже.</span>
    <?php else: ?>
        <form action="/cbr/" method="POST">
            <select name="currency">
                <option>-- Выберете валюту --</option>
                <?php foreach ($arResult['CURRENCIES'] as $currency): ?>
                    <option <?= $currency['SELECTED'] ?>
                            value="<?= $currency['ID'] ?>"><?= $currency['NAME'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="submit" >Отправить</button>
        </form>
        <?php if (!empty($arResult['CURRENT'])) : ?>
            <?= PHP_EOL ?>
            <span>Стоймость за <?= $arResult['CURRENT']['NAME'] ?>  составляет <?= $arResult['CURRENT']['VALUE'] ?> &#8381;</span>
        <?php endif; ?>
    <?php endif; ?>
</section>
