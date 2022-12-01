## AdultPbn DLE Module
Небольшой модуль для DLE более удобного вывода ссылок c биржи [adultpbn](https://adultpbn.com/)

### Установка
1. Создать в корне сайта папку **adultpbn** и закинуть в нее скачанный с биржи файл **links.php**
2. Закинуть файл **adultpbn.php** в **engine/modules**
3. Ознакомиться [как передавать параметры](#передача-параметров) модулю
4. Ознакомиться какие есть [параметры](#доступные-параметры-для-передачи)
5. Подготовить include и вставить его в нужное место шаблона
6. При необходимости переопределить [константы](#константы-в-файле-adultpbnphp) в самом вверху файла **adultpbn.php**


### Передача параметров
При вызове модуля через include, ему можно передать параметры,
первый параметр должен начинаться со знака **?**, последующие со знака **&**

Пример передачи одного параметра
> {include file="engine/modules/adultpbn.php`?place`=sidebar"}

Пример передачи двух параметров
> {include file="engine/modules/adultpbn.php`?place`=sidebar`&blank`=true"}

Пример передачи трех параметров
> {include file="engine/modules/adultpbn.php`?place`=sidebar`&blank`=true`&delimiter`=<\br>"}


### Доступные параметры для передачи
| Параметр    | Принимает                                   | Описание                                                                                                                                                                                        | По умолчанию            |
|-------------|---------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------|
| `place`     | `any` `header` `sidebar` `content` `footer` | Местоположение для вывода ссылок, если не указать данный параметр, то будут отображены все ссылки которым без разницы где они должны отображаться                                               | `any`                   |
| `wstart`    | Любой текст или html                        | Переданное значение будет помещено `перед ссылками` на странице сайта                                                                                                                           | `null`                  |
| `wend`      | Любой текст или html                        | Переданное значение будет помещено `после ссылок` на странице сайта                                                                                                                             | `null`                  |
| `delimiter` | Любой текст или html                        | Разделитель между ссылками, например `<br>`                                                                                                                                                     | `null `                 |
| `domain`    | Любой текст                                 | Домен сайта, по умолчанию берется из конфига DLE (___engine/data/config.php___)                                                                                                                 | Значение из конфига DLE |
| `encoding`  | Любой текст                                 | Кодировка для вывода ссылок, по умолчанию берется из конфига DLE, но если модуль вызывается из файла со специфической кодировкой, то ее можно передать данным параметром                        | Значение из конфига DLE |
| `blank`     | `true` `false`                              | Если передано `true`, то ссылки будут открываться в новой вкладке                                                                                                                               | `false`                 |
| `log`       | `true` `false`                              | Если передано `true`, то все ошибки связанные с построением ссылок, будут записываться в файл ___lb-log.txt___ который должен будет появиться рядом с файлом ___links.php___ скачанным из биржи | `false`                 |
| `test`      | `true` `false`                              | Если передано `true`, то вместо реальных ссылок будут отображены тестовые, полезно для проверки внешнего вида ссылок                                                                            | `false`                 |
| `debug`     | `true` `false`                              | Если передано `true`, то все ошибки php и ошибки появившиеся при генерации ссылок - будут отображены (включать только при острой необходимости)                                                 | `false`                 |


### Константы в файле adultpbn.php
Константы хранят значения по умолчанию для параметров, если таковые не были переданы при вызове модуля, а также некоторую другую информацию, которую при необходимости можно поменять.

>`__LINKS_FILE`\
> Хранит путь к файлу links.php который был скачан на бирже adultpbn

>`__API_KEY`\
> API ключ выданный биржей adultpbn, по умолчанию он помещается внутрь файла
links.php при скачивание, но на всякий случай можно указать и вручную

>`__DISABLE_AUTOUPDATE`\
> Если `true` то автообновление файла (`__LINKS_FILE`) будет отключено

>`__DISABLE_CURL`\
> Если `true` то вместо CURL будет использоваться file_get_contents при обращение к бирже

#### Дальнейшие константы переопределяют стандартные значения параметров
>`__DOMAIN`\
> Стандартное значение для параметра `domain`

>`__ENCODING`\
> Стандартное значение для параметра `eoncoding`

>`__TIMEOUT`\
> Стандартное значение для параметра `timeout`

>`__BLANK`\
> Стандартное значение для параметра `blank`

>`__WSTART`\
> Стандартное значение для параметра `wstart`

>`__WEND`\
> Стандартное значение для параметра `wend`

>`__DELIMITER`\
> Стандартное значение для параметра `delimiter`