
Инстурукция по запуску:
-
1. **git clone https://github.com/naetkss/microservice**
 
2. **composer update**

3. **php artisan migrate**

4. **php artisan db:seed**

Используемые инструменты технологии:
-
- php 7.2
- lumen
- rabbit mq
- git
- mysql
- phpunut


Команды:
-
-  __queue:listen__ 

```php artisan queue:listen```

запустить воркер

    
- __amount:transfer {user_id} send {amount} {to_user}__

 ```php artisan amount:transfer 1 send 50 2```
 
 отправить от пользователя с id 1 50 единиц измерения баланса пользователю с id 2 


- __amount:transfer {user_id} in {amount}__

 ```php artisan amount:transfer 1 in 50```

 пополнить баланс пользователя с id 1 на 50 единиц измерения баланса

 
- __amount:transfer {user_id} out {amount}__
 
 ```php artisan amount:transfer 1 out 50```

  списать с баланса пользователя с id 1 50 единиц измерения баланса

Пояснительная записка:
-
* За основу микросервиса взят фреимворк люмен, так как он достаточно легкий, он поддерживает консольные команды.
* В качестве брокера очередей выбран rabbit mq, так как работает при минимальных настройках и гибк настраивается.
* В качеcтве сервера БД использется MySql, так как его возможностей достаточно для поставленой задачи.
* Написан unit тест  
