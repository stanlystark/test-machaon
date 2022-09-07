# Инструкция по развертке и запуску
1. Выполнить `setup.sh`
2. Зайти на [http://127.0.0.1:4080/](http://127.0.0.1:4080/)

Повторный запуск через `start.sh`. Если нужно сменить внешний порт, открыть файл `.env` и поменять, так же на **4030** порту открыт PMA для доступа к базе.

# Методы API

Схема запросов и ответов: `json`

### Без токена
| Метод | Ссылка      | Параметры                                            | Описание                                                            |
|-------|-------------|:-----------------------------------------------------|---------------------------------------------------------------------|
| PUT   | /api/link   | `url` - ссылка                                       | Создаёт сокращённую ссылку                                          |
| GET   | /api/link   | `code` - код                                         | Возвращает информацию по коду                                       |

### С токеном (доступен после регистрации)
| Метод  | Ссылка                 | Параметры                                            | Описание                                                            |
|--------|------------------------|:-----------------------------------------------------|---------------------------------------------------------------------|
| GET    | /api/admin/links       | `from` - от* <br/>`to` - до*                         | Список всех ссылок                                                  |
| GET    | /api/admin/link        | `code` - код<br/>`from` - от** <br/>`to` - до**<br/> | Информация по ссылке, так же можно отфильтровать переходы по ссылке |
| PATCH  | /api/admin/link        | `code` - код<br/>`target` - новая ссылка             | Изменение ссылки                                                    |
| DELETE | /api/admin/link        | `code` - код                                         | Удаление ссылки                                                     |
| GET    | /api/admin/transitions | `from` - от* <br/>`to` - до*<br/>                    | Список всех переходов                                               |

Токен передаётся отдельным параметром `access_token`

```
* Дата создания ссылки в формате timestamp
** Дата перехода по ссылке в формате timestamp
```


_P.S. Всё можно сделать лучше, я это понимаю._