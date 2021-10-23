# parser
Парсинг страницы сайта
Скрипт осуществляет страницы сайта https://mirinstrumenta.ua/category/pnevmogaykoverti.html.
Результаты парсинга сохраняются в БД logger (таблица site_info) с обязательными полями: id, date, domain_name, page_url, price. 
При наличии товаров с акционными ценами в таблицу записывается процент скидки и акционная цена. 

Структура таблицы site_info:
CREATE TABLE `site_info` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `domain_name` varchar(240) NOT NULL,
  `page_url` varchar(240) NOT NULL,
  `price` varchar(240) DEFAULT NULL,
  `stock_percent` varchar(240) DEFAULT NULL COMMENT 'Процент скидки',
  `stock_price` varchar(240) DEFAULT NULL COMMENT 'Акционная цена'
)

ALTER TABLE `site_info`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `site_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
