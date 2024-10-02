<?php
require_once "./index.php";
$v = true;
$cookie_valores = LeerCookie();
if ($cookie_valores == -1) {
    $v = false;
}
if (isset($_GET['cerrar_sesion'])) {
    $nombre_cookie = "pelukeria_cookie";

    setcookie($nombre_cookie, "", time() - 3600, "/proyecto");
    header("Location: /proyecto");
    exit();
}

$url = $_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluqueria</title>
    <link rel="icon" href="public/src/img/logo.ico" sizes="50x50" type="image/icon">
    <script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Rubik+Mono+One&family=Concert+One&display=swap" rel="stylesheet">

    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="./public/src/css/style.css">
    <style>
        :root {
            --navbar-color-rgb: rgb(214, 120, 124);
            --navbar-color-rgb: 214, 120, 124;
            --navbar-color: #d6787c;
            --navbar-text-color-rgb: rgba(255, 255, 255, .7);
            --navbar-text-color: #ffffff;

            --bs-primary: #a378d6;
            --bs-secondary: #d10363;
            --bs-success: #7cd678;
            --bs-info: #78d6a3;
            --bs-warning: #d6d278;
            --bs-danger: #d6a378;

            --bs-primary-bg-subtle: #664b86;
            --bs-secondary-bg-subtle: #dd428a;
            --bs-success-bg-subtle: #5da15a;
            --bs-info-bg-subtle: #5aa17a;
            --bs-warning-bg-subtle: #bbb869;
            --bs-danger-bg-subtle: #a17a5a;

            --text-subtle: #a378d6;
            --bs-table: #d6787c;
        }

        :root,
        [data-bs-theme=light] {
            --bs-body-bg: #f0ccce;
        }

        [data-bs-theme=dark] {
            --bs-body-bg: #1b0f0f;
        }

        main {
            flex: 1;
        }

        body {
            font-family: "Pacifico", cursive;
            font-weight: 400;
            font-style: normal;
            background-color: var(--bs-body-bg);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .inicio {
            font-family: "Concert One", sans-serif;
            font-weight: 400;
            font-style: normal;
            text-align: justify;
        }

        .imagenes {

            b,
            p,
            button {
                font-family: "Concert One", sans-serif;
                font-weight: 400;
                font-style: normal;
            }

            b {
                color: #d10363;
            }

            .card {
                border-color: #d6787c;
            }

            h1 {
                color: #d10363;
            }
        }

        h3 {
            color: #d10363;
        }

        .error {
            font-family: "Rubik Mono One", monospace;
            font-weight: 400;
            font-style: normal;
            font-size: 2rem;

            h1 {
                font-size: 5rem;
                margin-bottom: 1.5rem;
            }

            .leter {
                background-color: var(--navbar-color);
                padding: 2rem 0;
                width: 20rem;
                border-radius: 30% 70% 43% 57% / 36% 56% 44% 64%;
            }

            h2 {
                font-size: 3rem;
                color: var(--bs-info);
            }
        }

        a {
            color: var(--text-subtle);
            font-weight: bold;
        }

        .bd-navbar::after {
            background-image: linear-gradient(rgba(var(--navbar-color-rgb), 1), rgba(var(--navbar-color-rgb), 0.95))
        }

        .bd-navbar .navbar-brand {
            color: var(--navbar-text-color)
        }

        .bd-navbar .navbar-toggler,
        .bd-navbar .nav-link {
            color: var(--navbar-text-color-rgb)
        }

        .bd-navbar .navbar-toggler:hover,
        .bd-navbar .navbar-toggler:focus,
        .bd-navbar .nav-link:hover,
        .bd-navbar .nav-link:focus {
            color: var(--navbar-text-color)
        }

        .bd-navbar .navbar-toggler.active,
        .bd-navbar .nav-link.active {
            color: var(--navbar-text-color)
        }

        .bd-navbar .offcanvas-lg {
            background-color: var(--navbar-color);
        }

        .bd-navbar .dropdown-menu {
            --bs-dropdown-link-hover-bg: rgba(var(--navbar-color-rgb), .8);
            --bs-dropdown-link-active-bg: rgba(var(--navbar-color-rgb), 1);
        }

        .container-login {
            max-width: 25rem;
        }

        .img-listar {
            width: 100%;
            height: 350px;
            object-fit: cover;
        }

        .p-link-theme {
            padding-top: .5rem !important;
            padding-bottom: .7rem !important;
        }

        .offcanvas-title {
            color: var(--navbar-text-color) !important;
        }

        .dropdown-item {
            font-size: 1.2rem;
        }

        .dropdown-item:hover {
            color: #fff !important;
        }

        .dropdown-item:checked {
            color: #fff !important;
        }

        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .btn-primary:hover {
            background-color: var(--bs-primary-bg-subtle);
            border-color: var(--bs-primary-bg-subtle);
        }

        .btn-danger {
            background-color: var(--bs-danger);
            border-color: var(--bs-danger);
        }

        .btn-danger:hover {
            background-color: var(--bs-danger-bg-subtle);
            border-color: var(--bs-danger-bg-subtle);
        }

        .btn-success {
            background-color: var(--bs-success);
            border-color: var(--bs-success);
        }

        .btn-success:hover {
            background-color: var(--bs-success-bg-subtle);
            border-color: var(--bs-success-bg-subtle);
        }

        .btn-warning {
            background-color: var(--bs-warning);
            border-color: var(--bs-warning);
        }

        .btn-warning:hover {
            background-color: var(--bs-warning-bg-subtle);
            border-color: var(--bs-warning-bg-subtle);
        }

        .btn-secondary {
            background-color: var(--bs-secondary);
            border-color: var(--bs-secondary);
        }

        .btn-secondary:hover {
            background-color: var(--bs-secondary-bg-subtle);
            border-color: var(--bs-secondary-bg-subtle);
        }

        .btn-secondary:checked {
            background-color: var(--bs-secondary-bg-subtle);
            border-color: var(--bs-secondary-bg-subtle);
        }

        h1 {
            color: var(--text-subtle);
        }

        b {
            color: var(--text-subtle);
        }

        thead {
            tr {
                th {
                    background-color: var(--bs-table) !important;
                    border-radius: 8px 8px 0 0;
                    color: #ffffff !important;
                }
            }
        }

        tbody {
            th {
                color: var(--text-subtle) !important;
            }
        }

        .nav-link {
            font-size: 1.3rem;
        }

        .btn-group {
            width: 100%;
        }

        footer {
            background-color: var(--navbar-color);

            .nav-link {
                color: var(--navbar-text-color-rgb);
            }

            .nav-link:hover {
                color: var(--navbar-text-color);
            }

            .nav-link:checked {
                color: var(--navbar-text-color);
            }

            .active {
                color: var(--navbar-text-color);
            }
        }
    </style>
</head>

<body>

    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
        </symbol>
        <symbol id="book-half" viewBox="0 0 16 16">
            <path
                d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
        </symbol>
        <symbol id="box-seam" viewBox="0 0 16 16">
            <path
                d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
        </symbol>
        <symbol id="braces" viewBox="0 0 16 16">
            <path
                d="M2.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C3.25 2 2.49 2.759 2.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6zM13.886 7.9v.163c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456V7.332c-1.114 0-1.49-.362-1.49-1.456V4.352C13.51 2.759 12.75 2 11.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6z" />
        </symbol>
        <symbol id="braces-asterisk" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C2.25 2 1.49 2.759 1.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6ZM14.886 7.9v.164c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456v-1.3c-1.114 0-1.49-.362-1.49-1.456V4.352C14.51 2.759 13.75 2 12.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6ZM7.5 11.5V9.207l-1.621 1.621-.707-.707L6.792 8.5H4.5v-1h2.293L5.172 5.879l.707-.707L7.5 6.792V4.5h1v2.293l1.621-1.621.707.707L9.208 7.5H11.5v1H9.207l1.621 1.621-.707.707L8.5 9.208V11.5h-1Z" />
        </symbol>
        <symbol id="check2" viewBox="0 0 16 16">
            <path
                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="chevron-expand" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M3.646 9.146a.5.5 0 0 1 .708 0L8 12.793l3.646-3.647a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 0-.708zm0-2.292a.5.5 0 0 0 .708 0L8 3.207l3.646 3.647a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 0 0 0 .708z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="clipboard" viewBox="0 0 16 16">
            <path
                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
            <path
                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
        </symbol>
        <symbol id="code" viewBox="0 0 16 16">
            <path
                d="M5.854 4.854a.5.5 0 1 0-.708-.708l-3.5 3.5a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146zm4.292 0a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8l-3.147-3.146z" />
        </symbol>
        <symbol id="file-earmark-richtext" viewBox="0 0 16 16">
            <path
                d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
            <path
                d="M4.5 12.5A.5.5 0 0 1 5 12h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm0-2A.5.5 0 0 1 5 10h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm1.639-3.708 1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047l1.888.974V8.5a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V8s1.54-1.274 1.639-1.208zM6.25 6a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5z" />
        </symbol>
        <symbol id="globe2" viewBox="0 0 16 16">
            <path
                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z" />
        </symbol>
        <symbol id="grid-fill" viewBox="0 0 16 16">
            <path
                d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z" />
        </symbol>
        <symbol id="lightning-charge-fill" viewBox="0 0 16 16">
            <path
                d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z" />
        </symbol>
        <symbol id="list" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
        </symbol>
        <symbol id="magic" viewBox="0 0 16 16">
            <path
                d="M9.5 2.672a.5.5 0 1 0 1 0V.843a.5.5 0 0 0-1 0v1.829Zm4.5.035A.5.5 0 0 0 13.293 2L12 3.293a.5.5 0 1 0 .707.707L14 2.707ZM7.293 4A.5.5 0 1 0 8 3.293L6.707 2A.5.5 0 0 0 6 2.707L7.293 4Zm-.621 2.5a.5.5 0 1 0 0-1H4.843a.5.5 0 1 0 0 1h1.829Zm8.485 0a.5.5 0 1 0 0-1h-1.829a.5.5 0 0 0 0 1h1.829ZM13.293 10A.5.5 0 1 0 14 9.293L12.707 8a.5.5 0 1 0-.707.707L13.293 10ZM9.5 11.157a.5.5 0 0 0 1 0V9.328a.5.5 0 0 0-1 0v1.829Zm1.854-5.097a.5.5 0 0 0 0-.706l-.708-.708a.5.5 0 0 0-.707 0L8.646 5.94a.5.5 0 0 0 0 .707l.708.708a.5.5 0 0 0 .707 0l1.293-1.293Zm-3 3a.5.5 0 0 0 0-.706l-.708-.708a.5.5 0 0 0-.707 0L.646 13.94a.5.5 0 0 0 0 .707l.708.708a.5.5 0 0 0 .707 0L8.354 9.06Z" />
        </symbol>
        <symbol id="menu-button-wide-fill" viewBox="0 0 16 16">
            <path
                d="M1.5 0A1.5 1.5 0 0 0 0 1.5v2A1.5 1.5 0 0 0 1.5 5h13A1.5 1.5 0 0 0 16 3.5v-2A1.5 1.5 0 0 0 14.5 0h-13zm1 2h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1zm9.927.427A.25.25 0 0 1 12.604 2h.792a.25.25 0 0 1 .177.427l-.396.396a.25.25 0 0 1-.354 0l-.396-.396zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2H1zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2h14zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path
                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path
                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="palette2" viewBox="0 0 16 16">
            <path
                d="M0 .5A.5.5 0 0 1 .5 0h5a.5.5 0 0 1 .5.5v5.277l4.147-4.131a.5.5 0 0 1 .707 0l3.535 3.536a.5.5 0 0 1 0 .708L10.261 10H15.5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-.5.5H3a2.99 2.99 0 0 1-2.121-.879A2.99 2.99 0 0 1 0 13.044m6-.21 7.328-7.3-2.829-2.828L6 7.188v5.647zM4.5 13a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0zM15 15v-4H9.258l-4.015 4H15zM0 .5v12.495V.5z" />
            <path d="M0 12.995V13a3.07 3.07 0 0 0 0-.005z" />
        </symbol>
        <symbol id="plugin" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1 8a7 7 0 1 1 2.898 5.673c-.167-.121-.216-.406-.002-.62l1.8-1.8a3.5 3.5 0 0 0 4.572-.328l1.414-1.415a.5.5 0 0 0 0-.707l-.707-.707 1.559-1.563a.5.5 0 1 0-.708-.706l-1.559 1.562-1.414-1.414 1.56-1.562a.5.5 0 1 0-.707-.706l-1.56 1.56-.707-.706a.5.5 0 0 0-.707 0L5.318 5.975a3.5 3.5 0 0 0-.328 4.571l-1.8 1.8c-.58.58-.62 1.6.121 2.137A8 8 0 1 0 0 8a.5.5 0 0 0 1 0Z" />
        </symbol>
        <symbol id="plus" viewBox="0 0 16 16">
            <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path
                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
        <symbol id="three-dots" viewBox="0 0 16 16">
            <path
                d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
        </symbol>
        <symbol id="tools" viewBox="0 0 16 16">
            <path
                d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.356 3.356a1 1 0 0 0 1.414 0l1.586-1.586a1 1 0 0 0 0-1.414l-3.356-3.356a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0zm9.646 10.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708zM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11z" />
        </symbol>
        <symbol id="ui-radios" viewBox="0 0 16 16">
            <path
                d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM0 12a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm7-1.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zM3 1a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm0 4.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
        </symbol>
    </svg>

    <header class="navbar navbar-expand-lg bd-navbar fixed-top p-1">
        <nav class="container-fluid bd-gutter flex-wrap flex-lg-nowrap" aria-label="Main navigation">
            <a class="navbar-brand p-0 me-0" href="/proyecto" aria-label="Bootstrap">
                <img src="public/src/img/logo.png" alt="logo" width="auto" height="50">
            </a>

            <div class="d-flex">
                <button class="navbar-toggler d-flex d-lg-none order-3 p-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="bi" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                    </svg>
                </button>
            </div>

            <div class="offcanvas-lg offcanvas-end flex-grow-1" tabindex="-1" id="bdNavbar"
                aria-labelledby="bdNavbarOffcanvasLabel" data-bs-scroll="true">
                <div class="offcanvas-header px-4 pb-0">
                    <h3 class="offcanvas-title text-warning" id="bdNavbarOffcanvasLabel">Peluqueria</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close" data-bs-target="#bdNavbar"></button>
                </div>

                <div class="offcanvas-body p-4 pt-0 p-lg-0">
                    <hr class="d-lg-none text-white-50">
                    <ul class="navbar-nav flex-row flex-wrap bd-navbar-nav align-content-center">
                        <li class="nav-item col-6 col-lg-auto">
                            <a class="nav-link py-2 px-0 px-lg-2 <?php echo (($url == '/proyecto/') ? 'active' : '') ?>"
                                aria-current="true" href="/proyecto">Inicio</a>
                        </li>
                        <li class="nav-item col-6 col-lg-auto">
                            <a class="nav-link py-2 px-0 px-lg-2 <?php echo (strpos($url, 'proyecto/oferta') ? 'active' : '') ?>"
                                href="/proyecto/oferta">Ofertas</a>
                        </li>
                        <li class="nav-item col-6 col-lg-auto">
                            <a class="nav-link py-2 px-0 px-lg-2 <?php echo (strpos($url, 'proyecto/servicio') ? 'active' : '') ?>"
                                href="/proyecto/servicio">Servicios</a>
                        </li>
                        <li class="nav-item col-6 col-lg-auto">
                            <a class="nav-link py-2 px-0 px-lg-2 <?php echo (strpos($url, 'proyecto/reserva') ? 'active' : '') ?>"
                                href="/proyecto/reserva">Reservas</a>
                        </li>
                        <li class="nav-item col-6 col-lg-auto">
                            <a class="nav-link py-2 px-0 px-lg-2 <?php echo (strpos($url, 'proyecto/contacto') ? 'active' : '') ?>"
                                href="/proyecto/contacto">Contactos</a>
                        </li>
                    </ul>

                    <hr class="d-lg-none text-white-50">

                    <ul class="navbar-nav flex-row flex-wrap ms-md-auto">

                        <?php if ($v && $cookie_valores['rol_nombre'] != 'cliente'): ?>
                            <li class="nav-item dropdown">
                                <button type="button"
                                    class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle <?php echo (strpos($url, 'proyecto/admin') ? 'active' : '') ?>"
                                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                    Admin
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <h6 class="dropdown-header">Usuario</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center justify-content-between  <?php echo (strpos($url, 'proyecto/admin/usuario') ? 'active' : '') ?>"
                                            aria-current="true" href="/proyecto/admin/usuario">
                                            Usuarios
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center justify-content-between <?php echo (strpos($url, 'proyecto/admin/rol') ? 'active' : '') ?>"
                                            aria-current="true" href="/proyecto/admin/rol">
                                            Roles
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <h6 class="dropdown-header">Servicios</h6>
                                    </li>
                                    <li><a class="dropdown-item <?php echo (strpos($url, 'proyecto/admin/servicio') ? 'active' : '') ?>"
                                            href="/proyecto/admin/servicio">Servicios</a></li>
                                    <li><a class="dropdown-item <?php echo (strpos($url, 'proyecto/admin/oferta') ? 'active' : '') ?>"
                                            href="/proyecto/admin/oferta">Ofertas</a></li>
                                    <li><a class="dropdown-item <?php echo (strpos($url, 'proyecto/admin/reserva') ? 'active' : '') ?>"
                                            href="/proyecto/admin/reserva">Reservas</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item  <?php echo (strpos($url, 'proyecto/admin/contacto') ? 'active' : '') ?>"
                                            href="/proyecto/admin/contacto">Contactos</a></li>
                                </ul>
                            </li>

                            <li class="nav-item py-2 py-lg-1 col-12 col-lg-auto">
                                <div class="d-none d-lg-flex h-100 mx-lg-2"></div>
                                <hr class="d-lg-none my-2 text-white-50">
                            </li>
                        <?php endif; ?>

                        <li class="nav-item dropdown align-content-center">
                            <button
                                class="btn btn-link nav-link p-link-theme px-0 dropdown-toggle d-flex align-items-center"
                                id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown"
                                data-bs-display="static" aria-label="Toggle theme (auto)">
                                <svg class="bi my-1 theme-icon-active">
                                    <use href="#circle-half"></use>
                                </svg>
                                <span class="d-lg-none ms-2" id="bd-theme-text">Cambiar tema</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme-text">
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="light" aria-pressed="false">
                                        <svg class="bi me-2">
                                            <use href="#sun-fill"></use>
                                        </svg>
                                        Claro
                                        <svg class="bi ms-auto d-none">
                                            <use href="#check2"></use>
                                        </svg>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="dark" aria-pressed="false">
                                        <svg class="bi me-2">
                                            <use href="#moon-stars-fill"></use>
                                        </svg>
                                        Oscuro
                                        <svg class="bi ms-auto d-none">
                                            <use href="#check2"></use>
                                        </svg>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center active"
                                        data-bs-theme-value="auto" aria-pressed="true">
                                        <svg class="bi me-2">
                                            <use href="#circle-half"></use>
                                        </svg>
                                        Auto
                                        <svg class="bi ms-auto d-none">
                                            <use href="#check2"></use>
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item py-2 py-lg-1 col-12 col-lg-auto">
                            <div class="d-none d-lg-flex h-100 mx-lg-2"></div>
                            <hr class="d-lg-none my-2 text-white-50">
                        </li>

                        <li class="nav-item dropdown">
                            <button type="button" class="btn nav-link p-0 px-lg-2 dropdown-toggl"
                                data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                <span class="fs-4">
                                    <?php if ($v): ?>
                                        <i class="bi bi-person-fill-check"></i>
                                    <?php else: ?>
                                        <i class="bi bi-person-fill-exclamation"></i>
                                    <?php endif; ?>
                                </span>
                                <span class="d-lg-none ms-2" id="bd-theme-text">
                                    <?php
                                    if ($v)
                                        echo $cookie_valores['nombre'] . ' ' . $cookie_valores['apellido_paterno'] . ' ' . $cookie_valores['apellido_materno'];
                                    else
                                        echo 'Usuario';
                                    ?>
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <h6 class="dropdown-header">Usuario</h6>
                                </li>
                                <?php if ($v): ?>
                                    <li><a class="dropdown-item" href="/proyecto/informacion">Información</a></li>
                                    <li><a class="dropdown-item" href="/proyecto/reserva">Reservas</a></li>
                                    <li>
                                        <form method="get" action="">
                                            <button type="submit" name="cerrar_sesion" value="si"
                                                class="dropdown-item text-danger fw-bold">Cerrar sesion</button>
                                        </form>
                                    </li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="/proyecto/login">Iniciar sesion</a></li>
                                    <li><a class="dropdown-item" href="/proyecto/register">Registrar</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5 pt-3">
        <?php echo $contenido; ?>
    </main>
    <?php
    /*
    echo '<pre><code>';
    print_r($cookie_valores);
    echo '</code></pre>';*/
    ?>
    <footer class="py-5 mt-4">
        <ul class="nav justify-content-center pb-3 mb-3">
            <li class="nav-item"><a href="/proyecto"
                    class="nav-link px-2 <?php echo (($url == '/proyecto/') ? 'active' : '') ?>">Home</a></li>
            <li class="nav-item"><a href="/proyecto/oferta"
                    class="nav-link px-2 <?php echo (strpos($url, 'proyecto/oferta') ? 'active' : '') ?>">Ofertas</a>
            </li>
            <li class="nav-item"><a href="/proyecto/servicio"
                    class="nav-link px-2 <?php echo (strpos($url, 'proyecto/servicio') ? 'active' : '') ?>">Servicios</a>
            </li>
            <li class="nav-item"><a href="/proyecto/reserva"
                    class="nav-link px-2 <?php echo (strpos($url, 'proyecto/reserva') ? 'active' : '') ?>">Reservas</a>
            </li>
            <li class="nav-item"><a href="/proyecto/contacto"
                    class="nav-link px-2 <?php echo (strpos($url, 'proyecto/contacto') ? 'active' : '') ?>">Contactos</a>
            </li>
        </ul>
        <p class="text-center text-white-50 fs-4">&copy; 2024 Grupo 2</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>