<?php
// view.php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Service — История заказов</title>
    <style>
        :root {
            --bg: #f8f9fa;
            --card-bg: #ffffff;
            --text-main: #2d3436;
            --text-secondary: #636e72;
            --accent: #00b894;
            --border: #dfe6e9;
            --row-hover: #f1f3f5;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            line-height: 1.6;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        h2 { font-weight: 700; margin: 0; font-size: 1.5rem; letter-spacing: -0.5px; }

        .nav-links a {
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-left: 20px;
            transition: color 0.2s;
        }

        .nav-links a:hover { color: var(--accent); }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 0; /* Убираем внутренний отступ для таблицы */
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        th {
            background-color: #fafbfc;
            text-align: left;
            padding: 16px 24px;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
        }

        tr:last-child td { border-bottom: none; }

        tr:hover td { background-color: var(--row-hover); }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            background: #e9ecef;
            color: #495057;
        }

        .badge-online {
            background: #e6fffa;
            color: #087f5b;
        }

        .empty-state {
            padding: 40px;
            text-align: center;
            color: var(--text-secondary);
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h2>История заказов</h2>
        <nav class="nav-links">
            <a href="index.php">Главная</a>
            <a href="form.html">Новый заказ</a>
        </nav>
    </header>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Заказчик</th>
                    <th>Кол-во</th>
                    <th>Ресторан</th>
                    <th>Упаковка</th>
                    <th>Оплата</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(file_exists("data.txt")) {
                    $orders = file("data.txt", FILE_IGNORE_NEW_LINES);
                    if (empty($orders)) {
                        echo "<tr><td colspan='5' class='empty-state'>Заказов пока нет</td></tr>";
                    } else {
                        foreach(array_reverse($orders) as $order) {
                            $data = explode("|", $order);
                            // Структура: Имя|Кол-во|Ресторан|Упаковка|Онлайн-оплата
                            $name = htmlspecialchars($data[0] ?? '—');
                            $qty = htmlspecialchars($data[1] ?? '0');
                            $rest = htmlspecialchars($data[2] ?? '—');
                            $pack = htmlspecialchars($data[3] ?? '—');
                            $pay = htmlspecialchars($data[4] ?? 'Нет');
                            
                            $payBadgeClass = ($pay === 'Да') ? 'badge-online' : '';
                            
                            echo "<tr>
                                    <td><b>$name</b></td>
                                    <td>$qty</td>
                                    <td>$rest</td>
                                    <td><span class='badge'>$pack</span></td>
                                    <td><span class='badge $payBadgeClass'>$pay</span></td>
                                  </tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='5' class='empty-state'>Файл данных не найден</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>