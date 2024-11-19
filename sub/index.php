<?php

function bytesformat($bytes, $precision = 2): string
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

if ((isset($_SERVER['HTTP_USER_AGENT']) and empty($_SERVER['HTTP_USER_AGENT'])) or !isset($_SERVER['HTTP_USER_AGENT'])) {
    header('Location: /');
    exit();
}

if (!function_exists('str_contains'))
    die('Please upgrade your PHP version to 8 or above');
$isTextHTML = str_contains(($_SERVER['HTTP_ACCEPT'] ?? ''), 'text/html');

// Replace "example.com" with your domain name.
// If your panel port is 443 or 80, there is no need to enter the port.
const BASE_URL = "https://example.com:port";

$URL = BASE_URL . $_SERVER['REQUEST_URI'] ?? '';
$URL .= $isTextHTML ? '/info' : '';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 17);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
if (curl_error($ch))
    die('Error !' . __LINE__ . '<br>Please check <a href="https://github.com/AC-Lover/AC-Subcription/wiki/Error-!27">this</a>');
curl_close($ch);


$header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
$response = trim(str_replace($header_text, '', $response));
$user = json_decode($response, true);

if ($isTextHTML) {
    ?>
    <!doctype html>
    <html lang="en" data-bs-theme="system">
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="A service for those who love being here but appearing there — travel the world without packing a suitcase!">
        <meta name="theme-color" content="#fff">
        <title>Flexify</title>
        <link href="https://raw.githubusercontent.com/dermv/marzbanify-template/refs/heads/main/img/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">
        <link href="https://raw.githubusercontent.com/dermv/marzbanify-template/refs/heads/main/img/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">
        <link href="https://raw.githubusercontent.com/dermv/marzbanify-template/refs/heads/main/img/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH">
        <style>
          .bi {
            width: 1em;
            height: 1em;
            vertical-align: -.125em;
            fill: currentcolor;
          }
          
          .tab-pane {
            counter-reset: guide-step 0;
          }
          
          .my-block {
            padding: 1rem;
          }
          
          .my-block-big {
            padding: 1.5rem;
            padding-top: .5rem;
          }
          
          .my-block, .my-block-big {
            border-radius: var(--bs-border-radius-xl);
          }
          
          .my-btn {
            --bs-btn-bg: rgba(35, 131, 226, .15);
            --bs-btn-color: #2383e2;
            --bs-btn-hover-bg: rgba(35, 131, 226, .2);
            --bs-btn-hover-border-color: transparent;
            --bs-btn-hover-color: #2383e2;
            --bs-btn-active-bg: rgba(35, 131, 226, .25);
            --bs-btn-active-border-color: transparent;
            --bs-btn-active-color: #2383e2;
            --bs-btn-border-radius: var(--bs-border-radius-xl);
            --bs-btn-focus-shadow-rgb: 35, 131, 226;
            --bs-btn-font-weight: 600;
          }
          
          .my-color-green {
            color: #1aad3a;
          }
          
          .my-color-red {
            color: #ea4e43;
          }
          
          .my-color-blue {
            color: #0a85d1;
          }
          
          .my-color-yellow {
            color: #fb3;
          }
          
          .my-container {
            max-width: 64rem;
          }
          
          .my-dropdown-menu {
            --bs-dropdown-border-radius: var(--bs-border-radius-xl);
            --bs-dropdown-item-padding-x: .75rem;
            --bs-dropdown-item-padding-y: .5rem;
            --bs-dropdown-padding-x: .35rem;
            --bs-dropdown-padding-y: .35rem;
          
            li + li {
              margin-top: .35rem;
            }
          
            .dropdown-item {
              border-radius: .75rem;
            }
          
            .my-dropdown-item-check {
              color: transparent;
            }
          }
          
          .my-step-icon {
            color: #57b5ef;
            display: block;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: .5rem;
          
            user-select: none;
            -moz-user-select: none;
            -webkit-user-select: none;
          
            &::after {
              counter-increment: guide-step;
              content: counter(guide-step);
            }
          }
          
          .my-toast {
            --bs-toast-bg: #2383e2;
            --bs-toast-border-radius: var(--bs-border-radius-xl);
            --bs-toast-border-width: 0;
            --bs-toast-color: #fff;
            --bs-toast-padding-x: 1rem;
          }
          
          [data-bs-theme='light'] {
            --bs-body-bg: #fff;
          
            .my-block, .my-block-big {
              background-color: #f6f5f4;
            }
          
            .my-dropdown-menu {
              --bs-dropdown-link-hover-bg: #f6f5f4;
              --bs-dropdown-link-active-bg: #eaeaea;
              --bs-dropdown-link-active-color: #000;
          
              .my-dropdown-item-icon, .active .my-dropdown-item-check {
                color: rgba(0, 0, 0, .5);
              }
            }
          
            .my-nav-link {
              --bs-nav-link-color: rgba(var(--bs-emphasis-color-rgb), .65);
              --bs-nav-link-hover-color: rgba(var(--bs-emphasis-color-rgb), .9);
            }
          }
          
          [data-bs-theme='dark'] {
            --bs-body-bg: #151515;
          
            .my-block, .my-block-big {
              background-color: #232323;
            }
          
            .my-dropdown-menu {
              --bs-dropdown-link-hover-bg: #232323;
              --bs-dropdown-link-active-bg: #333;
              --bs-dropdown-link-active-color: #fff;
          
              .my-dropdown-item-icon, .active .my-dropdown-item-check {
                color: rgba(255, 255, 255, .5);
              }
            }
          
            .my-nav-link {
              --bs-nav-link-color: rgba(var(--bs-emphasis-color-rgb), .65);
              --bs-nav-link-hover-color: rgba(var(--bs-emphasis-color-rgb), .9);
            }
          }
        </style>
      </head>
      <body>
        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
          <!-- Icons from https://icons.getbootstrap.com -->
          <symbol id="android" viewBox="0 0 16 16">
            <path d="M2.76 3.061a.5.5 0 0 1 .679.2l1.283 2.352A8.9 8.9 0 0 1 8 5a8.9 8.9 0 0 1 3.278.613l1.283-2.352a.5.5 0 1 1 .878.478l-1.252 2.295C14.475 7.266 16 9.477 16 12H0c0-2.523 1.525-4.734 3.813-5.966L2.56 3.74a.5.5 0 0 1 .2-.678ZM5 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m6 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
          </symbol>
          <symbol id="apple" viewBox="0 0 16 16">
            <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516s1.52.087 2.475-1.258.762-2.391.728-2.43m3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422s1.675-2.789 1.698-2.854-.597-.79-1.254-1.157a3.7 3.7 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56s.625 1.924 1.273 2.796c.576.984 1.34 1.667 1.659 1.899s1.219.386 1.843.067c.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758q.52-1.185.473-1.282"/>
          </symbol>
          <symbol id="arrow-down-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5"/>
          </symbol>
          <symbol id="arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
          </symbol>
          <symbol id="calendar3" viewBox="0 0 16 16">
            <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
            <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
          </symbol>
          <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
          </symbol>
          <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16"/>
          </symbol>
          <symbol id="emoji-frown-fill" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m-2.715 5.933a.5.5 0 0 1-.183-.683A4.5 4.5 0 0 1 8 9.5a4.5 4.5 0 0 1 3.898 2.25.5.5 0 0 1-.866.5A3.5 3.5 0 0 0 8 10.5a3.5 3.5 0 0 0-3.032 1.75.5.5 0 0 1-.683.183M10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8"/>
          </symbol>
          <symbol id="emoji-smile-fill" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8"/>
          </symbol>
          <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/>
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.73 1.73 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.73 1.73 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.73 1.73 0 0 0 1.097-1.097zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
          </symbol>
          <symbol id="pc-display" viewBox="0 0 16 16">
            <path d="M0 4s0-2 2-2h12s2 0 2 2v6s0 2-2 2h-4q0 1 .25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75Q6 13 6 12H2s-2 0-2-2zm1.398-.855a.76.76 0 0 0-.254.302A1.5 1.5 0 0 0 1 4.01V10c0 .325.078.502.145.602q.105.156.302.254a1.5 1.5 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.76.76 0 0 0 .254-.302 1.5 1.5 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.76.76 0 0 0-.302-.254A1.5 1.5 0 0 0 13.99 3H2c-.325 0-.502.078-.602.145"/>
          </symbol>
          <symbol id="repeat" viewBox="0 0 16 16">
            <path d="M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192m3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z"/>
          </symbol>
          <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/>
          </symbol>
          <symbol id="translate" viewBox="0 0 16 16">
            <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286zm1.634-.736L5.5 3.956h-.049l-.679 2.022z"/>
            <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zm7.138 9.995q.289.451.63.846c-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6 6 0 0 1-.415-.492 2 2 0 0 1-.94.31"/>
          </symbol>
        </svg>
        <div class="container my-container py-3" x-data>
          <header class="d-flex flex-wrap align-items-center gap-2 mb-5">
            <img src="https://raw.githubusercontent.com/dermv/marzbanify-template/refs/heads/main/img/logo.png" class="me-auto" alt="Logo" width="32" height="32">
            <ul class="nav align-items-center">
              <li class="nav-item">
                <a class="nav-link my-nav-link fw-semibold px-2" href="https://t.me/" rel="noopener noreferrer" target="_blank" x-text="$t('support')"></a>
              </li>
              <li class="nav-item">
                <div class="dropdown">
                  <button class="nav-link my-nav-link dropdown-toggle d-flex align-items-center px-2" id="btn-theme" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg class="bi my-dropdown-icon-active fs-5"><use href="#sun"></use></svg>
                  </button>
                  <ul class="dropdown-menu my-dropdown-menu">
                    <li>
                      <button class="dropdown-item active d-flex align-items-center fw-semibold" type="button" data-theme-value="system" aria-pressed="true">
                        <svg class="bi my-dropdown-item-icon me-2"><use href="#circle-half"></use></svg>
                        <span class="me-2" x-text="$t('system')"></span>
                        <svg class="bi my-dropdown-item-check ms-auto"><use href="#check2"></use></svg>
                      </button>
                    </li>
                    <li>
                      <button class="dropdown-item d-flex align-items-center fw-semibold" type="button" data-theme-value="light" aria-pressed="false">
                        <svg class="bi my-dropdown-item-icon me-2"><use href="#sun-fill"></use></svg>
                        <span class="me-2" x-text="$t('light')"></span>
                        <svg class="bi my-dropdown-item-check ms-auto"><use href="#check2"></use></svg>
                      </button>
                    </li>
                    <li>
                      <button class="dropdown-item d-flex align-items-center fw-semibold" type="button" data-theme-value="dark" aria-pressed="false">
                        <svg class="bi my-dropdown-item-icon me-2"><use href="#moon-stars-fill"></use></svg>
                        <span class="me-2" x-text="$t('dark')"></span>
                        <svg class="bi my-dropdown-item-check ms-auto"><use href="#check2"></use></svg>
                      </button>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <div class="dropdown">
                  <button class="nav-link my-nav-link dropdown-toggle d-flex align-items-center px-2" id="btn-lang" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg class="bi fs-5"><use href="#translate"></use></svg>
                  </button>
                  <ul class="dropdown-menu my-dropdown-menu">
                    <li>
                      <button class="dropdown-item active d-flex align-items-center fw-semibold" type="button" data-language-value="en" aria-pressed="true">
                        <span class="me-2">English</span>
                        <svg class="bi my-dropdown-item-check ms-auto"><use href="#check2"></use></svg>
                      </button>
                    </li>
                    <li>
                      <button class="dropdown-item d-flex align-items-center fw-semibold" type="button" data-language-value="ru" aria-pressed="false">
                        <span class="me-2">Русский</span>
                        <svg class="bi my-dropdown-item-check ms-auto"><use href="#check2"></use></svg>
                      </button>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </header>
          <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
            <span class="fs-3 fw-bold me-auto" x-text="$t('subscription')"></span>
            <button class="btn my-btn" id="btn-copy-link" type="button" x-text="$t('copyLink')"></button>
            <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3">
              <div class="toast my-toast" id="toast-copy-link" role="alert" aria-atomic="true" aria-live="assertive">
                <div class="d-flex">
                  <div class="toast-body fs-6 fw-semibold">
                    <span x-text="$t('copiedToClipboard')"></span>
                  </div>
                  <button type="button" class="btn-close btn-close-white m-auto me-3" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
              </div>
            </div>
          </div>
          <div class="row row-cols-2 row-cols-sm-4 g-3 mb-5">
            <div class="col">
              <div class="my-block d-flex flex-column h-100">
                <?php if ($user['status'] === 'active'): ?>
                  <svg class="bi my-color-green fs-4 mb-2"><use href="#emoji-smile-fill"></use></svg>
                <?php else: ?>
                  <svg class="bi my-color-red fs-4 mb-2"><use href="#emoji-frown-fill"></use></svg>
                <?php endif; ?>
                <span class="fs-5 fw-bold" x-text="$t('status')"></span>
                <span class="fw-semibold" x-text="USER_STATUS == 'active' ? $t('active') : USER_STATUS == 'limited' ? $t('limited') : USER_STATUS == 'expired' ? $t('expired') : $t('disabled')"></span>
              </div>
            </div>
            <div class="col">
              <div class="my-block d-flex flex-column h-100">
                <svg class="bi my-color-red fs-4 mb-2"><use href="#calendar3"></use></svg>
                <span class="fs-5 fw-bold" x-text="$t('duration')"></span>
                <?php if (empty($user['expire'])): ?>
                  <span class="fw-semibold" x-text="$t('forever')"></span>
                <?php else: ?>
                  <span class="fw-semibold">
                    <span x-text="$t('until')"></span>
                    <?= date('d.m.Y', $user['expire']) ?>
                  </span>
                <?php endif; ?>
              </div>
            </div>
            <div class="col">
              <div class="my-block d-flex flex-column h-100">
                <svg class="bi my-color-blue fs-4 mb-2"><use href="#arrow-down-up"></use></svg>
                <span class="fs-5 fw-bold" x-text="$t('traffic')"></span>
                <span class="fw-semibold">
                  <?= bytesformat($user['used_traffic']) ?>
                  <span x-text="$t('of')"></span>
                  <?= empty($user['data_limit']) ? '∞' : bytesformat($user['data_limit']) ?>
                </span>
              </div>
            </div>
            <div class="col">
              <div class="my-block d-flex flex-column h-100">
                <svg class="bi my-color-yellow fs-4 mb-2"><use href="#repeat"></use></svg>
                <span class="fs-5 fw-bold" x-text="$t('trafficReset')"></span>
                <span class="fw-semibold" x-text="USER_RESET_STRATEGY == 'year' ? $t('yearly') : USER_RESET_STRATEGY == 'month' ? $t('monthly') : USER_RESET_STRATEGY == 'week' ? $t('weekly') : USER_RESET_STRATEGY == 'day' ? $t('daily') : $t('no')"></span>
              </div>
            </div>
          </div>
          <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
            <span class="fs-3 fw-bold me-auto" x-text="$t('guide')"></span>
            <div class="dropdown">
              <button class="nav-link my-nav-link dropdown-toggle d-flex align-items-center" id="btn-guide" type="button" data-bs-toggle="dropdown">
                <svg class="bi my-dropdown-icon-active fs-5 me-2"><use href="#pc-display"></use></svg>
                <span class="my-dropdown-text-active fw-semibold"></span>
              </button>
              <ul class="dropdown-menu my-dropdown-menu" role="tablist">
                <li>
                  <button class="dropdown-item active d-flex align-items-center fw-semibold" type="button" data-bs-target="#tab-pc" data-bs-toggle="tab" role="tab" aria-controls="tab-pc" aria-selected="true">
                    <svg class="bi my-dropdown-item-icon me-2"><use href="#pc-display"></use></svg>
                    <span class="me-2" x-text="$t('pc')"></span>
                    <svg class="bi my-dropdown-item-check ms-auto"><use href="#check2"></use></svg>
                  </button>
                </li>
                <li>
                  <button class="dropdown-item d-flex align-items-center fw-semibold" type="button" data-bs-target="#tab-android" data-bs-toggle="tab" role="tab" aria-controls="tab-android" aria-selected="false">
                    <svg class="bi my-dropdown-item-icon me-2"><use href="#android"></use></svg>
                    <span class="me-2">Android</span>
                    <svg class="bi my-dropdown-item-check ms-auto"><use href="#check2"></use></svg>
                  </button>
                </li>
                <li>
                  <button class="dropdown-item d-flex align-items-center fw-semibold" type="button" data-bs-target="#tab-ios" data-bs-toggle="tab" role="tab" aria-controls="tab-ios" aria-selected="false">
                    <svg class="bi my-dropdown-item-icon me-2"><use href="#apple"></use></svg>
                    <span class="me-2">iOS</span>
                    <svg class="bi my-dropdown-item-check ms-auto"><use href="#check2"></use></svg>
                  </button>
                </li>
              </ul>
            </div>
          </div>
          <div class="tab-content" role="tablist">
            <div id="tab-pc" class="tab-pane fade show active" aria-labelledby="Guide for PC" role="tabpanel">
              <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                <div class="col">
                  <div class="my-block-big h-100">
                    <span class="my-step-icon"></span>
                    <h4 class="fw-bold" x-text="$t('guideContent.pc.first.title')"></h4>
                    <p class="fw-semibold" x-text="$t('guideContent.pc.first.subtitle')"></p>
                    <a class="icon-link my-color-blue link-underline link-underline-opacity-0 link-underline-opacity-50-hover" href="https://github.com/hiddify/hiddify-next/releases/latest" rel="noopener noreferrer" target="_blank">
                      <span class="fw-semibold" x-text="$t('openPage')"></span>
                      <svg class="bi" aria-hidden="true"><use href="#arrow-right"></use></svg>
                    </a>
                  </div>
                </div>
                <div class="col">
                  <div class="my-block-big h-100">
                    <span class="my-step-icon"></span>
                    <h4 class="fw-bold" x-text="$t('guideContent.pc.second.title')"></h4>
                    <p class="fw-semibold" x-text="$t('guideContent.pc.second.subtitle')"></p>
                    <a class="icon-link my-color-blue link-underline link-underline-opacity-0 link-underline-opacity-50-hover" href="hiddify://import/<?= $user['subscription_url'] ?>" rel="noopener noreferrer" target="_blank">
                      <span class="fw-semibold" x-text="$t('addSubscription')"></span>
                      <svg class="bi" aria-hidden="true"><use href="#arrow-right"></use></svg>
                    </a>
                  </div>
                </div>
                <div class="col">
                  <div class="my-block-big h-100">
                    <span class="my-step-icon"></span>
                    <h4 class="fw-bold" x-text="$t('guideContent.pc.third.title')"></h4>
                    <span class="fw-semibold" x-text="$t('guideContent.pc.third.subtitle')"></span>
                  </div>
                </div>
              </div>
            </div>
            <div id="tab-android" class="tab-pane fade" aria-labelledby="Guide for Android" role="tabpanel">
              <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                <div class="col">
                  <div class="my-block-big h-100">
                    <span class="my-step-icon"></span>
                    <h4 class="fw-bold" x-text="$t('guideContent.android.first.title')"></h4>
                    <p class="fw-semibold" x-text="$t('guideContent.android.first.subtitle')"></p>
                    <a class="icon-link my-color-blue link-underline link-underline-opacity-0 link-underline-opacity-50-hover" href="https://play.google.com/store/apps/details?id=app.hiddify.com" rel="noopener noreferrer" target="_blank">
                      <span class="fw-semibold" x-text="$t('openPage')"></span>
                      <svg class="bi" aria-hidden="true"><use href="#arrow-right"></use></svg>
                    </a>
                  </div>
                </div>
                <div class="col">
                  <div class="my-block-big h-100">
                    <span class="my-step-icon"></span>
                    <h4 class="fw-bold" x-text="$t('guideContent.android.second.title')"></h4>
                    <p class="fw-semibold" x-text="$t('guideContent.android.second.subtitle')"></p>
                    <a class="icon-link my-color-blue link-underline link-underline-opacity-0 link-underline-opacity-50-hover" href="hiddify://import/<?= $user['subscription_url'] ?>" rel="noopener noreferrer" target="_blank">
                      <span class="fw-semibold" x-text="$t('addSubscription')"></span>
                      <svg class="bi" aria-hidden="true"><use href="#arrow-right"></use></svg>
                    </a>
                  </div>
                </div>
                <div class="col">
                  <div class="my-block-big h-100">
                    <span class="my-step-icon"></span>
                    <h4 class="fw-bold" x-text="$t('guideContent.android.third.title')"></h4>
                    <span class="fw-semibold" x-text="$t('guideContent.android.third.subtitle')"></span>
                  </div>
                </div>
              </div>
            </div>
            <div id="tab-ios" class="tab-pane fade" aria-labelledby="Guide for iOS" role="tabpanel">
              <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                <div class="col">
                  <div class="my-block-big h-100">
                    <span class="my-step-icon"></span>
                    <h4 class="fw-bold" x-text="$t('guideContent.ios.first.title')"></h4>
                    <p class="fw-semibold" x-text="$t('guideContent.ios.first.subtitle')"></p>
                    <a class="icon-link my-color-blue link-underline link-underline-opacity-0 link-underline-opacity-50-hover" href="https://apps.apple.com/app/hiddify-proxy-vpn/id6596777532" rel="noopener noreferrer" target="_blank">
                      <span class="fw-semibold" x-text="$t('openPage')"></span>
                      <svg class="bi" aria-hidden="true"><use href="#arrow-right"></use></svg>
                    </a>
                  </div>
                </div>
                <div class="col">
                  <div class="my-block-big h-100">
                    <span class="my-step-icon"></span>
                    <h4 class="fw-bold" x-text="$t('guideContent.ios.second.title')"></h4>
                    <p class="fw-semibold" x-text="$t('guideContent.ios.second.subtitle')"></p>
                    <a class="icon-link my-color-blue link-underline link-underline-opacity-0 link-underline-opacity-50-hover" href="hiddify://import/<?= $user['subscription_url'] ?>" rel="noopener noreferrer" target="_blank">
                      <span class="fw-semibold" x-text="$t('addSubscription')"></span>
                      <svg class="bi" aria-hidden="true"><use href="#arrow-right"></use></svg>
                    </a>
                  </div>
                </div>
                <div class="col">
                  <div class="my-block-big h-100">
                    <span class="my-step-icon"></span>
                    <h4 class="fw-bold" x-text="$t('guideContent.ios.third.title')"></h4>
                    <span class="fw-semibold" x-text="$t('guideContent.ios.third.subtitle')"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs-i18n@2.x.x/dist/cdn.min.js"></script>
        <script>
          const USER_STATUS = `<?= $user['status'] ?>`;
          const USER_RESET_STRATEGY = `<?= $user['data_limit_reset_strategy'] ?>`;

          const META_THEME_COLORS = {light: '#fff', dark: '#151515'};
          const MESSAGES = {
            en: {
              support: 'Support',
              system: 'System',
              light: 'Light',
              dark: 'Dark',
              status: 'Status',
              active: 'Active',
              limited: 'Limited',
              expired: 'Expired',
              disabled: 'Disabled',
              duration: 'Duration',
              until: 'Until',
              forever: 'Forever',
              traffic: 'Traffic',
              of: 'of',
              trafficReset: 'Traffic Reset',
              no: 'No',
              daily: 'Daily',
              weekly: 'Weekly',
              monthly: 'Monthly',
              yearly: 'Yearly',
              subscription: 'Subscription',
              copyLink: 'Copy link',
              copiedToClipboard: 'Copied to clipboard',
              guide: 'Guide',
              pc: 'PC',
              openPage: 'Open page',
              addSubscription: 'Add subscription',
              guideContent: {
                pc: {
                  first: {
                    title: 'Install and open Hiddify',
                    subtitle: `Go to the latest release page on GitHub. Download the
                    file for your OS and install the app. Launch it, select the «Russia»
                    region (in the startup window or settings), then press «Start».`,
                  },
                  second: {
                    title: 'Add the subscription',
                    subtitle: `Press the button below — the app will open, and the
                    subscription will be added automatically. If this doesn’t happen,
                    close the app and try again, or add the subscription manually using
                    the «+» button in the top right corner.`,
                  },
                  third: {
                    title: 'Connect and enjoy',
                    subtitle: `On the main page, press the large power button in the
                    center to connect to the VPN. If needed, choose a different server on
                    the proxy page. Enjoy :)`,
                  },
                },
                android: {
                  first: {
                    title: 'Install and open Hiddify',
                    subtitle: `Open the page in Google Play and install the app. Launch
                    it, select the «Russia» region (in the startup window or in
                    settings), then press «Start».`,
                  },
                  second: {
                    title: 'Add the subscription',
                    subtitle: `Press the button below — the app will open, and the
                    subscription will be added automatically. If this doesn’t happen,
                    close the app and try again, or add the subscription manually using
                    the «+» button in the top right corner.`,
                  },
                  third: {
                    title: 'Connect and enjoy',
                    subtitle: `On the main page, press the large power button in the
                    center to connect to the VPN. If needed, choose a different server by
                    tapping on the «>» icon at the bottom. Enjoy :)`,
                  },
                },
                ios: {
                  first: {
                    title: 'Install and open Hiddify',
                    subtitle: `Open the page in the App Store and install the app. Launch
                    the app, tap «Allow» in the VPN configuration permission window,
                    and enter your passcode. In the startup screen (or in settings, if
                    you missed it), select the «Russia» region, then tap «Start».`,
                  },
                  second: {
                    title: 'Add the subscription',
                    subtitle: `Tap the button below and in the pop-up window, tap «Open»
                    — the app will open, and the subscription will be added
                    automatically. If this doesn’t happen, close the app and try again,
                    or manually add the subscription using the «+» button in the top
                    right corner.`,
                  },
                  third: {
                    title: 'Connect and enjoy',
                    subtitle: `On the main page, press the large power button in the
                    center to connect to the VPN. If needed, choose a different server by
                    tapping on the «>» icon at the bottom. Enjoy :)`,
                  },
                },
              },
            },
            ru: {
              support: 'Поддержка',
              system: 'Системная',
              light: 'Светлая',
              dark: 'Темная',
              status: 'Статус',
              active: 'Активна',
              limited: 'Ограничена',
              expired: 'Истекла',
              disabled: 'Отключена',
              duration: 'Срок',
              until: 'До',
              forever: 'Навсегда',
              traffic: 'Трафик',
              of: 'из',
              trafficReset: 'Сброс трафика',
              no: 'Нет',
              daily: 'Ежедневно',
              weekly: 'Еженедельно',
              monthly: 'Ежемесячно',
              yearly: 'Ежегодно',
              subscription: 'Подписка',
              copyLink: 'Скопировать ссылку',
              copiedToClipboard: 'Скопировано в буфер обмена',
              guide: 'Инструкция',
              pc: 'ПК',
              openPage: 'Открыть страницу',
              addSubscription: 'Добавить подписку',
              guideContent: {
                pc: {
                  first: {
                    title: 'Установи и открой Hiddify',
                    subtitle: `Перейди на страницу последнего релиза на GitHub. Скачай
                    файл для своей ОС и установи приложение. Запусти его, выбери регион
                    «Россия» (в стартовом окне или в настройках), затем нажми «Старт».`,
                  },
                  second: {
                    title: 'Добавь подписку',
                    subtitle: `Нажми кнопку ниже — приложение откроется, и подписка
                    добавится автоматически. Если этого не произошло, закрой приложение
                    и попробуй снова или добавь подписку вручную через «+» в правом
                    верхнем углу.`,
                  },
                  third: {
                    title: 'Подключись и пользуйся',
                    subtitle: `На главной странице нажми большую кнопку включения в
                    центре для подключения к VPN. При необходимости выбери другой сервер
                    на странице прокси. Пользуйся :)`,
                  },
                },
                android: {
                  first: {
                    title: 'Установи и открой Hiddify',
                    subtitle: `Открой страницу в Google Play и установи приложение.
                    Запусти его, выбери регион «Россия» (в стартовом окне или в
                    настройках), затем нажми «Старт».`,
                  },
                  second: {
                    title: 'Добавь подписку',
                    subtitle: `Нажми кнопку ниже — приложение откроется, и подписка
                    добавится автоматически. Если этого не произошло, закрой приложение
                    и попробуй снова или добавь подписку вручную через «+» в правом
                    верхнем углу.`,
                  },
                  third: {
                    title: 'Подключись и пользуйся',
                    subtitle: `На главной странице нажми большую кнопку включения в
                    центре для подключения к VPN. Если нужно, выбери другой сервер, нажав
                    на «>» внизу. Пользуйся :)`,
                  },
                },
                ios: {
                  first: {
                    title: 'Установи и открой Hiddify',
                    subtitle: `Открой страницу в App Store и установи приложение. Запусти
                    приложение, в окне разрешения на добавление конфигураций VPN нажми
                    «Разрешить» и введи свой код-пароль. В стартовом окне (или в
                    настройках, если пропустил) выбери регион «Россия», а затем нажми
                    «Старт».`,
                  },
                  second: {
                    title: 'Добавь подписку',
                    subtitle: `Нажми на кнопку ниже и в появившемся окне нажми «Открыть»
                    — откроется приложение, и подписка добавится автоматически. Если это
                    не произошло, закрой приложение и попробуй снова, либо добавь
                    подписку вручную через кнопку «+» в правом верхнем углу.`,
                  },
                  third: {
                    title: 'Подключись и пользуйся',
                    subtitle: `На главной странице нажми большую кнопку включения в
                    центре для подключения к VPN. Если нужно, выбери другой сервер, нажав
                    на «>» внизу. Пользуйся :)`,
                  },
                },
              },
            },
          };
          
          function getPreferredGuideTab() {
            const userAgent = navigator.userAgent.toLowerCase();
            if (userAgent.includes('android')) {
              return '#tab-android';
            } else if (userAgent.includes('iphone') || userAgent.includes('ipad')) {
              return '#tab-ios';
            } else {
              return '#tab-pc';
            }
          }
          
          function getPreferredLanguage() {
            return (
              localStorage.getItem('language') ||
              (navigator.language || navigator.userLanguage).slice(0, 2)
            );
          }
          
          function getPreferredTheme() {
            return localStorage.getItem('theme') || 'system';
          }
          
          function setTheme(theme) {
            if (theme === 'system') {
              theme = window.matchMedia('(prefers-color-scheme: dark)').matches
                ? 'dark'
                : 'light';
            }
          
            document.documentElement.setAttribute('data-bs-theme', theme);
            document
              .querySelector(`[name='theme-color']`)
              .setAttribute('content', META_THEME_COLORS[theme]);
          }
          
          function showActiveDropdownButton(btn, selectedBtn, isIndependent) {
            // Change dropdowns that can't be changed because
            // they don't depend on Bootstrap.
            if (isIndependent) {
              const activeDropdownBtn = btn.nextElementSibling.querySelector('.active');
              if (activeDropdownBtn) {
                activeDropdownBtn.classList.remove('active');
                activeDropdownBtn.setAttribute('aria-pressed', 'false');
              }
              
              selectedBtn.classList.add('active');
              selectedBtn.setAttribute('aria-pressed', 'true');
            }
          
            const btnIcon = btn.querySelector('.my-dropdown-icon-active use');
            const selectedBtnIcon = selectedBtn.querySelector('svg use');
            if (btnIcon && selectedBtnIcon) {
              btnIcon.setAttribute('href', selectedBtnIcon.getAttribute('href'));
            }
          
            const btnText = btn.querySelector('.my-dropdown-text-active');
            const selectedBtnText = selectedBtn.querySelector('span');
            if (btnText && selectedBtnText) {
              selectedBtnText.classList.remove('me-2');
              btnText.innerHTML = selectedBtnText.outerHTML;
            }
          }
          
          document.addEventListener('alpine-i18n:ready', () => {
            window.AlpineI18n.fallbackLocale = 'en';
            window.AlpineI18n.create(getPreferredLanguage(), MESSAGES);
          
            const btnLang = document.getElementById('btn-lang');
            const btnPrefLang = document.querySelector(
              `[data-language-value="${getPreferredLanguage()}"]`,
            );
            showActiveDropdownButton(btnLang, btnPrefLang, true);
            document.querySelectorAll('[data-language-value]').forEach(btn => {
              btn.addEventListener('click', () => {
                localStorage.setItem('language', btn.dataset.languageValue);
                AlpineI18n.locale = btn.dataset.languageValue;
                showActiveDropdownButton(btnLang, btn, true);
              });
            });
          });
          
          document.addEventListener('DOMContentLoaded', () => {
            setTheme(getPreferredTheme());
            window.matchMedia('(prefers-color-scheme: dark)')
              .addEventListener('change', () => {
                if (getPreferredTheme() === 'system') setTheme('system');
              });
          
            const btnTheme = document.getElementById('btn-theme');
            const btnPrefTheme = document.querySelector(
              `[data-theme-value="${getPreferredTheme()}"]`,
            );
            showActiveDropdownButton(btnTheme, btnPrefTheme, true);
            document.querySelectorAll('[data-theme-value]').forEach(btn => {
              btn.addEventListener('click', () => {
                localStorage.setItem('theme', btn.dataset.themeValue);
                setTheme(btn.dataset.themeValue);
                showActiveDropdownButton(btnTheme, btn, true);
              });
            });
          
            const btnGuide = document.getElementById('btn-guide');
            const btnPrefGuideTab = document.querySelector(
              `[data-bs-target="${getPreferredGuideTab()}"]`,
            );
            bootstrap.Tab.getOrCreateInstance(btnPrefGuideTab).show();
            showActiveDropdownButton(btnGuide, btnPrefGuideTab);
            document.querySelectorAll('[data-bs-target]').forEach(btn => {
              btn.addEventListener('click', () => {
                showActiveDropdownButton(btnGuide, btn);
              });
            });
          
            const toastCopyLink = document.getElementById('toast-copy-link');
            document.getElementById('btn-copy-link').addEventListener('click', () => {
              navigator.clipboard.writeText(`<?= $user['subscription_url'] ?>`);
              bootstrap.Toast.getOrCreateInstance(toastCopyLink).show();
            });
          });
        </script>
      </body>
    </html>
        <?php
        return;
}

$isOK = false;
foreach (explode("\r\n", $header_text) as $i => $line) {
    if ($i === 0)
        continue;
    list($key, $value) = explode(': ', $line);
    if (in_array($key, ['content-disposition', 'content-type', 'subscription-userinfo', 'profile-update-interval'])) {
        header("$key: $value");
        $isOK = true;
    }
}

if (!$isTextHTML and !$isOK)
    die('Error !' . __LINE__);


echo $response;

?>