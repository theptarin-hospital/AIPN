<!doctype html>
<html lang="en" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.84.0">
    <head>

        <title><?= $this->renderSection("pageTitle") ?></title>

    </head>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/cover/">



    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="<?= base_url('asset/bs-examples/cover/cover.css'); ?>" rel="stylesheet">
    <body class="d-flex h-100 text-center text-white bg-dark">

        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
            <header class="mb-auto">
                <div>
                    <h3 class="float-md-start mb-0">TRH AIPN</h3>
                    <nav class="nav nav-masthead justify-content-center float-md-end">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('aipn'); ?>">Home</a>
                        <a class="nav-link" href="<?= base_url('upload'); ?>">Upload</a>
                        <a class="nav-link" href="<?= base_url('about'); ?>">Contact</a>
                    </nav>
                </div>
            </header>
            <main class="px-3">
                <!--Area for dynamic content -->
                <?= $this->renderSection("content") ?>
            </main>
            <footer class="mt-auto text-white-50">
                <!-- Copyright Section-->
                <div class="copyright py-4 text-center text-white">
                    <p><small><?= lang('app.welcome') ?></small></p>
                    <p>Page rendered in {elapsed_time} seconds</p>
                    <p>TRH CI4 Environment: <?= ENVIRONMENT ?></p>
                    <div class="container"><small><?= lang('app.copyright') ?></small></div>
                </div>
            </footer>
        </div>
    </body>
</html>