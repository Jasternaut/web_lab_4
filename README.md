# Лабораторная работа №4: Composer, классы и работа с публичным API

## 📌 Описание задания
- Освоить Composer и структуру vendor.
- Научиться работать с классами и внешними библиотеками.
- Научиться получать и отображать данные из публичного API.
- Отработать работу с куками и пользовательской информацией.

---

## ⚙️ Как запустить проект

1. Клонировать репозиторий:
   ```bash
   git clone https://github.com/Jasternaut/web_lab_4
   cd web_lab_4
2. Выполнить инициализацию composer:
   ```bash
   cd www
   composer init
   composer require guzzlehttp/guzzle
3. Запустить контейнеры:
   ```bash
   docker-compose up -d --build
   ```
Открыть в браузере:
```http://localhost:8080```

## 📂 Содержимое проекта

```docker-compose.yml``` — описание сервиса Nginx

```www/index.php``` — главная страница

```www/form.html``` – страница с формой

```www/process.php``` – файл с обработками

```www/view.php``` – вывод заказов

```www/ApiClient.php``` – интеграция api

```www/UserInfo.php``` – сбор данных

```www/refresh_api.php``` – управление кешем

```screenshots/``` — все скриншоты

## 📸 Скриншоты работы

<img width="400" src="./screenshots/index.png"></img>
<img width="400" src="./screenshots/history.png"></img>
