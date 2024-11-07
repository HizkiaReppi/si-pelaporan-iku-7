@php
    $title = null;
    $content = 'Panduan Pengguna';
    $baseUrl = config('app.url');
    $baseUrl = explode('://', $baseUrl)[1];

    if (request()->secure()) {
        $baseUrl = 'https://' . $baseUrl;
    } else {
        $baseUrl = 'http://' . $baseUrl;
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-meta-data :title="$content" csrfToken="{{ csrf_token() }}" :baseurl="$baseUrl"/>
    <script src="https://kit.fontawesome.com/29057e6c17.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        header {
            background-color: #ff6600;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0;
            height: 40px;
            flex-shrink: 0;
        }
        header h1 {
            font-size: 1rem;
            margin: 0;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
            margin-left: 10px;
            text-align: center;
        }
        .header-actions {
            display: flex;
            align-items: center;
            margin: 0;
        }
        .header-actions button {
            display: inline-flex;
            align-items: center;
            color: #ff6600;
            background-color: white;
            border: none;
            text-decoration: none;
            height: 40px;
            font-size: 1rem;
            font-weight: 600;
            padding: 0 15px;
            cursor: pointer;
        }
        .galley_view {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .galley_view iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        .button-text {
            margin-left: 5px;
        }
        @media screen and (min-width: 768px) {
            header h1 {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-actions">
            <button id="back-button">
                <i class="fa-solid fa-arrow-left"></i>
                <span class="button-text">Kembali</span>
            </button>
        </div>
        <h1>{{ $content }}</h1>
    </header>
    <div id="pdfCanvasContainer" class="galley_view">
        <iframe src="https://docs.google.com/presentation/d/e/2PACX-1vRvSK_BWqFePhmdLDFKldE1aD3tjgYRTncuDjHyuhAedq7GwwdjrnoLYj28q429pg/embed?start=false&loop=false&delayms=60000" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
    </div>

    <script>
        const backButton = document.getElementById('back-button');
        backButton.addEventListener('click', () => {
            window.history.back();
        });
    </script>
</body>
</html>
