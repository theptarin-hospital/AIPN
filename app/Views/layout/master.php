<html>

    <head>

        <title><?= $this->renderSection("pageTitle") ?></title>

    </head>

    <body>
        <header>
            ...
        </header>

        <nav>
            ...
        </nav>

        <!--Area for dynamic content -->
        <?= $this->renderSection("content") ?>

        <footer>
            ...
        </footer>   

    <body>

</html>