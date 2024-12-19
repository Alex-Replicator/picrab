<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
    <title>Админ-панель</title>
</head>
<body class="bg-light">
<header>
    <div class="container p-0  bg-white border-bottom">
        <div class="row">
            <div class="col-lg-2 d-flex align-items-center p-3">
                <span href="#" class="px-md-4 fw-medium brand fs-3">PiCrab</span>
            </div>
            <div class="col-md-9 col-lg-10 d-md p-3">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <ul class="navbar-nav ms-0">
                            <li class="nav-item">
                                <a href="#" class="nav-link">Админ-панель</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Настройки</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Логи</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Задачи воркера</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">|</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">Перейти на сайт</a>
                            </li>
                        </ul>
                        <div class="d-flex align-items-center">
                            <img src="https://www.meme-arsenal.com/memes/049bda12d7f90540e8c2c95a1f5c3d79.jpg" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
                            <span class="fw-medium me-3">Alex</span>
                            <button class="btn btn-outline-danger btn-sm">Выйти</button>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar p-3 border-end">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuKeywords">
                        Ключевики
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="menuKeywords">
                        <ul class="list-unstyled ps-3">
                            <li><a href="#" class="nav-link">Все Ключевики</a></li>
                            <li><a href="#" class="nav-link">Создать Ключевики</a></li>
                            <li><a href="#" class="nav-link">Архив Ключевиков</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuArticles">
                        Статьи
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="menuArticles">
                        <ul class="list-unstyled ps-3">
                            <li><a href="#" class="nav-link">Все Статьи</a></li>
                            <li><a href="#" class="nav-link">Создать Статьи</a></li>
                            <li><a href="#" class="nav-link">Архив Статей</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuProfiles">
                        Профили
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="menuProfiles">
                        <ul class="list-unstyled ps-3">
                            <li><a href="#" class="nav-link">Все Профили</a></li>
                            <li><a href="#" class="nav-link">Создать Профили</a></li>
                            <li><a href="#" class="nav-link">Архив Профилей</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuProxies">
                        Прокси
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="menuProxies">
                        <ul class="list-unstyled ps-3">
                            <li><a href="#" class="nav-link">Все Прокси</a></li>
                            <li><a href="#" class="nav-link">Создать Прокси</a></li>
                            <li><a href="#" class="nav-link">Архив Прокси</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuAPI">
                        API
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="menuAPI">
                        <ul class="list-unstyled ps-3">
                            <li><a href="#" class="nav-link">Все API</a></li>
                            <li><a href="#" class="nav-link">Создать API</a></li>
                            <li><a href="#" class="nav-link">Архив API</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuAccounts">
                        Аккаунты
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="menuAccounts">
                        <ul class="list-unstyled ps-3">
                            <li><a href="#" class="nav-link">Все Аккаунты</a></li>
                            <li><a href="#" class="nav-link">Создать Аккаунты</a></li>
                            <li><a href="#" class="nav-link">Архив Аккаунтов</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuWorkflow">
                        Workflow
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse" id="menuWorkflow">
                        <ul class="list-unstyled ps-3">
                            <li><a href="#" class="nav-link">Все Workflow</a></li>
                            <li><a href="#" class="nav-link">Создать Workflow</a></li>
                            <li><a href="#" class="nav-link">Архив Workflow</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-white">
            <div class="content mt-4">
                <h2>Добро пожаловать</h2>
                <p>Тут пока просто задачи для воркера"</p>
                <div class="table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Тип задачи</th>
                            <th>Статус</th>
                            <th>Дата создания</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>12</td>
                            <td>Генерация статьи по ключевику <a href="#">эскорт мск</a></td>
                            <td>Активен</td>
                            <td>18.12.2024 19:12:24</td>
                            <td><button class="btn btn-sm btn-danger ">Остановить</button></td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>Генерация статьи по ключевику <a href="#">эскорт дубай</a></td>
                            <td>Создан</td>
                            <td>18.12.2024 19:12:35</td>
                            <td>
                                <button class="btn btn-sm btn-success">Запустить</button>
                                <button class="btn btn-sm btn-primary ms-2">Редактировать</button>
                                <button class="btn btn-sm btn-danger ms-2">Удалить</button>
                            </td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>Генерация статьи по ключевику <a href="#">эскорт спб</a></td>
                            <td>Создан</td>
                            <td>18.12.2024 19:12:46</td>
                            <td>
                                <button class="btn btn-sm btn-success">Запустить</button>
                                <button class="btn btn-sm btn-primary ms-2">Редактировать</button>
                                <button class="btn btn-sm btn-danger ms-2">Удалить</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <h2>Дамп контейнера модулей</h2>
                <pre>
                    <code>
object(Closure)#16 (5) {
  ["name"]=>
  string(43) "{closure:/var/www/html/public/index.php:16}"
  ["file"]=>
  string(30) "/var/www/html/public/index.php"
  ["line"]=>
  int(16)
  ["static"]=>
  array(5) {
    ["db"]=>
    object(Picrab\Components\Database\Database)#7 (0) {
    }
    ["modulesManager"]=>
    object(Picrab\Components\ModulesManager\ModulesManager)#10 (2) {
      ["db":"Picrab\Components\ModulesManager\ModulesManager":private]=>
      object(Picrab\Components\Database\Database)#7 (0) {
      }
      ["modules":"Picrab\Components\ModulesManager\ModulesManager":private]=>
      array(4) {
        ["header"]=>
        object(Picrab\Modules\Header\Header)#11 (0) {
        }
        ["footer"]=>
        object(Picrab\Modules\Footer\Footer)#12 (0) {
        }
        ["menu"]=>
        object(Picrab\Modules\Menu\Menu)#13 (0) {
        }
        ["auth"]=>
        object(Picrab\Modules\Auth\Auth)#14 (7) {
          ["renderer":"Picrab\Modules\Auth\Auth":private]=>
          object(Picrab\Components\Renderer\Renderer)#15 (1) {
            ["currentTheme":"Picrab\Components\Renderer\Renderer":private]=>
            string(7) "default"
          }
          ["renderModule":"Picrab\Modules\Auth\Auth":private]=>
          *RECURSION*
          ["params":"Picrab\Modules\Auth\Auth":private]=>
          array(2) {
            ["pageContent"]=>
            array(7) {
              ["id"]=>
              int(1)
              ["title"]=>
              string(15) "Это сайт"
              ["content"]=>
              string(30) "
Это главная
"
              ["slug"]=>
              string(4) "main"
              ["pageTypeID"]=>
              int(1)
              ["pageTypeSlug"]=>
              string(4) "main"
              ["action"]=>
              string(4) "view"
            }
            ["db"]=>
            object(Picrab\Components\Database\Database)#7 (0) {
            }
          }
          ["model":"Picrab\Modules\Auth\Auth":private]=>
          NULL
          ["config":"Picrab\Modules\Auth\Auth":private]=>
          NULL
          ["error":"Picrab\Modules\Auth\Auth":private]=>
          NULL
          ["check":"Picrab\Modules\Auth\Auth":private]=>
          int(1)
        }
      }
    }
    ["renderer"]=>
    object(Picrab\Components\Renderer\Renderer)#15 (1) {
      ["currentTheme":"Picrab\Components\Renderer\Renderer":private]=>
      string(7) "default"
    }
    ["renderModule"]=>
    *RECURSION*
    ["pageContent"]=>
    array(7) {
      ["id"]=>
      int(1)
      ["title"]=>
      string(15) "Это сайт"
      ["content"]=>
      string(30) "
Это главная
"
      ["slug"]=>
      string(4) "main"
      ["pageTypeID"]=>
      int(1)
      ["pageTypeSlug"]=>
      string(4) "main"
      ["action"]=>
      string(4) "view"
    }
  }
  ["parameter"]=>
  array(2) {
    ["$slug"]=>
    string(10) ""
    ["$submodule"]=>
    string(10) ""
  }
}
                    </code>
                </pre>
            </div>
        </main>
    </div>
</div>
<footer>
    <div class="container border-top">
        <div class="row bg-white">
            <div class="col-lg-12 p-3">
                <div class="p">&copy; Все права защищены</div>
            </div>
        </div>
    </div>
</footer>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
