<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$pageTitle|escape}</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/public/styles.css">
</head>
<body>
<header class="header">
    <div class="container header__container">
        <a class="header__logo" href="/">Blogy.</a>
    </div>
</header>
<main class="container main">
    {block name=content}{/block}
</main>
<footer class="footer">
    <div class="container footer__container">
        <span class="footer__text">Copyright © {$currentYear|escape} All Rights Reserved.</span>
    </div>
</footer>
</body>
</html>
