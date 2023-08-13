-- phpMyAdmin SQL Dump
-- version 4.1.0
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 11 2022 г., 20:22
-- Версия сервера: 5.1.73-community
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `justfun`
--

-- --------------------------------------------------------

--
-- Структура таблицы `costums`
--

CREATE TABLE IF NOT EXISTS `costums` (
  `costumeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description_cost` text,
  PRIMARY KEY (`costumeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `costums`
--

INSERT INTO `costums` (`costumeid`, `description_cost`) VALUES
(1, 'Человек-паук'),
(2, 'Свинка Пеппа (Джордж)'),
(3, 'Свинка Пеппа (Пеппа)'),
(4, 'Пират'),
(5, 'Леди Баг и Супер Кот (Леди Баг)'),
(6, 'Леди Баг и Супер Кот (Супер Кот)'),
(7, 'Фиксики (Симка)'),
(8, 'Фиксики (Нолик)'),
(9, 'Русалочка'),
(10, 'Тролль 1'),
(11, 'Тролль 2'),
(12, 'Тролль 3'),
(13, 'Лунтик'),
(14, 'Мила'),
(15, 'Маша'),
(16, 'Медведь'),
(17, 'Учёный');

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customerid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `login` varchar(20) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `email` char(30) DEFAULT NULL,
  `phone` char(20) DEFAULT NULL,
  PRIMARY KEY (`customerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`customerid`, `name`, `login`, `password`, `email`, `phone`) VALUES
(1, 'Иванов Иван Иванович', 'iii_1', 'bd4fcd7dfe528014c73084b5ec74ca49d815a4ee', 'ivanov@mail.ru', '74953740142'),
(2, 'Петров Петр Петрович', 'ppp_2', 'b76b3b1b8187fa132039b1e095be05ead19a54a7', 'petrov@mail.ru', '74953741758'),
(3, 'Сидоров Сидор Сидорович', 'sss_3', 'b195c3ee418c42293094e18d3c2df2d332697a82', 'sidorov@mail.ru', '74995861301'),
(4, 'Григорьев Григорий Григорьевич', 'ggg_4', 'c4870a72cae45cb3afefafc33124299378c8448b', 'grigoriev@mail.ru', '74995860591'),
(5, 'Денисов Денис Денисович', 'ddd_5', '89615b24445617d167b3a1a193ed5905d539e363', 'denisov@mail.ru', '74995861296'),
(6, 'Зайцев Иван Николаевич', 'zin_6', '7c04fbe5153f787f060292da87195de50b6bd9e8', 'zaya@mail.ru', '74953741652'),
(7, 'Робски Оксана', 'ro_7', '26210b9f87d91c982fda4451a833c14a5fb76579', 'robski@mail.ru', '74950097648'),
(8, 'Куприн Иван Николаевич', 'kup_8', '887698e2ae1f3f9a03a813e323faced85f220180', 'kuprin@mail.ru', '74992166013'),
(9, 'Кулагина Мария Петровна', 'kul_9', '7e65e9609aebf3be9c51d90705ad8c28a52e5994', 'kulagina@mail.ru', '79036038662'),
(15, 'Иван Иванович Ивенин', 'iiiI_1', 'aa5dbbb05539746eb525d453012cd715e03ebdfe', 'iii@mail.ru', '88005553535');

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `employid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `name` char(30) DEFAULT NULL,
  `yearstart` int(11) DEFAULT NULL,
  `post` char(30) DEFAULT NULL,
  `photo_employ` char(30) DEFAULT NULL,
  PRIMARY KEY (`employid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `employees`
--

INSERT INTO `employees` (`employid`, `login`, `password`, `name`, `yearstart`, `post`, `photo_employ`) VALUES
(1, 'lera', '21861d81afc6aac560d3ab37c16681e3ae97988b', 'Лера', 2018, 'Аниматор', 'employees1.jpg'),
(2, 'alina', 'c542a5c75409b4c42c96dea4fb6ddd50bf591c22', 'Алина', 2019, 'Аниматор', 'employees2.jpg'),
(3, 'tanya', '8aca103eae125bb908422862b88e0bde2ae947b5', 'Таня', 2019, 'Аниматор', 'employees3.jpg'),
(4, 'roma', 'a6b6ea31c49a8e944efe9ecbc072a26903a1461a', 'Рома', 2018, 'Аниматор', 'employees4.jpg'),
(5, 'dima', 'bed3f98d0a894717be46c58ffa90302af9946688', 'Дима', 2018, 'Аниматор', 'employees5.jpg'),
(6, 'sasha', 'def9a6e7c3a9785f219450a2543d1a42d8fd9ed3', 'Саша', 2018, 'Аниматор', 'employees6.jpg'),
(7, 'akradiy', '4357b5f1dae4bf5519559c8b80dfc4c30939a6f8', 'Аркадий', 2018, 'Звукорежиссёр', 'employees7.jpg'),
(8, 'kirill', '9b153e80bc985b32d577460a8a24e398d4182978', 'Кирилл', 2018, 'Звукорежиссёр', 'employees8.jpg'),
(9, 'alex', '60c6d277a8bd81de7fdde19201bf9c58a3df08f4', 'Алексей', 2019, 'Фотограф', 'employees9.jpg'),
(10, 'andrey', 'fd2b0a636ed0c80c1646cd2c2e72f7a758b42b5b', 'Андрей', 2020, 'Фотограф', 'employees10.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `feedbacks`
--

CREATE TABLE IF NOT EXISTS `feedbacks` (
  `feedbackid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customerid` int(10) unsigned NOT NULL,
  `quastion` text,
  `answer` text,
  `date_feed` date NOT NULL,
  PRIMARY KEY (`feedbackid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `feedbacks`
--

INSERT INTO `feedbacks` (`feedbackid`, `customerid`, `quastion`, `answer`, `date_feed`) VALUES
(1, 4, 'Сколько длится праздник Маши и медведя?', '2 часа', '2021-11-20'),
(2, 3, 'Сколько конфет в кэнди боксе?', '800 рублей', '2020-12-05'),
(3, 1, 'Какие размеры игрушек?', 'администратор в скором времени ответит на ваш вопрос', '2021-09-23'),
(4, 4, 'Сколько длится праздник Троллей?', 'администратор в скором времени ответит на ваш вопрос', '2021-11-20'),
(7, 2, 'Какие размеры пиньяты?', '50см на 70см', '2021-12-26'),
(8, 2, 'Сколько конфет в боксе????', 'администратор в скором времени ответит на ваш вопрос', '2021-12-26'),
(9, 2, 'Сколько по времени проходит праздник Маши и медведя?', '2 часа', '2021-12-26'),
(10, 1, 'Сколько длиться праздник Маши и медведя?', 'администратор в скором времени ответит на ваш вопрос', '2022-01-10'),
(11, 2, 'sdaadsdasasd', 'администратор в скором времени ответит на ваш вопрос', '2022-02-11'),
(12, 2, 'ggg', 'администратор в скором времени ответит на ваш вопрос', '2022-02-11'),
(13, 2, 'ppp', 'администратор в скором времени ответит на ваш вопрос', '2022-02-11'),
(14, 2, 'ff', 'администратор в скором времени ответит на ваш вопрос', '2022-02-11');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customerid` int(10) unsigned NOT NULL,
  `date_ord` char(100) NOT NULL,
  `place` char(100) NOT NULL,
  `time` char(10) NOT NULL,
  PRIMARY KEY (`orderid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`orderid`, `customerid`, `date_ord`, `place`, `time`) VALUES
(1, 1, '2021-09-30', 'Транспортная,23-45,Саранск', '12:00'),
(2, 7, '2021-07-09', 'Ульянова, 76-123,Саранск', '17:00'),
(3, 2, '2021-10-02', 'Попова, 67-75,Саранск', '14:00'),
(4, 4, '2021-06-13', 'Московская, 12-45,Саранск', '13:00'),
(5, 2, '2020-06-13', 'Попова, 67-75,Саранск', '13:00'),
(6, 2, '2022-06-13', 'Попова, 67-75,Саранск', '13:00'),
(7, 4, '2021-11-25', 'Московская, 12-45,Саранск', '16:00'),
(15, 1, '2022-01-25', 'ул.Лесная д.9', '16:38'),
(16, 1, '2022-01-20', 'Лесная 9', '13:00'),
(17, 1, '2022-01-15', 'ул.Лесная д.9', '19:50');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `orditemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` int(10) unsigned NOT NULL,
  `serviceid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`orditemid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`orditemid`, `orderid`, `serviceid`) VALUES
(1, 1, 3),
(2, 1, 6),
(3, 2, 8),
(4, 3, 1),
(5, 4, 2),
(6, 4, 6),
(7, 4, 7),
(8, 5, 4),
(9, 6, 2),
(10, 6, 8),
(11, 7, 3),
(26, 15, 3),
(27, 16, 1),
(28, 16, 4),
(29, 17, 1),
(30, 17, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `photoid` int(10) unsigned NOT NULL,
  `customerid` int(10) unsigned NOT NULL,
  `date_photo` date NOT NULL,
  `photo` char(30) DEFAULT NULL,
  PRIMARY KEY (`photoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`photoid`, `customerid`, `date_photo`, `photo`) VALUES
(1, 1, '2021-09-30', 'photos11.jpg'),
(2, 1, '2021-09-30', 'photos12.jpg'),
(3, 1, '2021-09-30', 'photos13.jpg'),
(4, 7, '2021-07-09', 'photos71.jpg'),
(5, 7, '2021-07-09', 'photos72.jpg'),
(6, 7, '2021-07-09', 'photos73.jpg'),
(7, 2, '2021-10-02', 'photos21.jpg'),
(8, 4, '2021-06-13', 'photos41.jpg'),
(9, 2, '2020-06-13', 'photos23.jpg'),
(10, 2, '2020-06-13', 'photos24.jpg'),
(11, 2, '2019-06-13', 'photos25.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `price`
--

CREATE TABLE IF NOT EXISTS `price` (
  `priceid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(30) DEFAULT NULL,
  `amount` float(8,2) DEFAULT NULL,
  PRIMARY KEY (`priceid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `price`
--

INSERT INTO `price` (`priceid`, `title`, `amount`) VALUES
(1, '1 аниматор', 500.00),
(2, '2 аниматора', 800.00),
(3, '3 аниматора', 1050.00),
(4, '4 аниматора', 1200.00);

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `reviewid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `review` text,
  `date_rew` date NOT NULL,
  `customerid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`reviewid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`reviewid`, `review`, `date_rew`, `customerid`) VALUES
(1, 'Спасибо, спасибо и еще раз спасибо за праздник! Детки счастливы, взрослые довольны!!! Праздник просто СУПЕР! ОГРОМНОЕ спасибо аниматорам ребята - вы умнички, благодаря вашему таланту, профессионализму, крутому гриму и костюмам мои детки побывали в сказке Алисы в стране чудес! Обещаю увидеться с вами в следующем году', '2021-09-30', 1),
(2, 'ОГРОМНОЕ СПАСИБО всей Вашей команде!!! Заказывали аниматоров на выпускной в детском саду, а также шарики и шоколадный фонтан. Всё очень понравилось и взрослым и главное детям. Наши выпускники 2 часа были под присмотром профессионалов, играли, развлекались до упаду!!! У нас были фиксики, костюмы очень красивые, все конкурсы очень продумана и адаптированы для этого возраста, что тоже не маловажно!!! Музыка, реквизит все на высоком уровне!!! Шоколадный фонтан - это отдельная история, очень советую на подобные мероприятия, наелись все и дети и родители!!! Шоколад НУ ОЧЕНЬ ВКУСНЫЙ!!! Короче сплошной позитив, хорошее настроение и классные фотки!!! Огромное спасибо за праздник от всех нас!!!!', '2021-07-09', 7),
(3, 'Хочу выразить большую благодарность, за проведение праздника в честь дня рождения нашей доченьки.Мы заказывали Вашего чудесного клоуна Витаминка 7 декабря.Столько радости подарили детишкам и нам взрослым! Дети аж пищали от восторга!!!Все конкурсы были по возрасту!Было так здорово... Праздник прошел на самом высоком уровне. Спасибо Вам Огромное!!! Желаем Вам творческих успехов, множества заказов', '2021-10-02', 2),
(4, 'Сегодня две волшебные феи Блум и Стелла устроили потрясающий праздник для моей доченьки!!!детки в садике в восторге, настоящая сказка,аквагрим на высоте!!!спасибо вам огромное!!!!! Вы превзошли все наши ожидания!!! Обязательно ещё неоднократно будем обращаться!!!вы мастера своего дела!!!', '2021-06-13', 4),
(5, 'Спасибо Вам большое за прекрасный и весёлый день рождения!Дети и взрослые остались очень довольны.Программа была супер!!!', '2020-10-21', 8),
(6, 'Спасибо большое Анне и Эльзе за прекрасный праздник!!!!!!Все было очень весело и сказочно! все дети остались довольны и еще долго вас вспоминали))В дальнейшем будем только вас приглашать на наши праздники!!!!!!', '2021-11-03', 6),
(7, 'Я заказывала аниматора впервые и даже не думала, что это будет так здорово и приведёт в восторг не только детей, но и взрослых, я веселилась вместе с детьми. Дети не отходили от Человека паука. Сын в восторге! Сказал, что теперь каждый свой день рождения хочет справлять именно так. Теперь в будущем только к Вам!!!', '2020-06-17', 5),
(8, 'Спасибо за Вашу работу!)', '2022-01-01', 1),
(12, 'Вы молодцы!!!', '2022-01-01', 1),
(13, 'Вы прекрасно работаете!', '2022-01-10', 1),
(14, 'Всё супер!', '2022-02-11', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `serviceid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(30) DEFAULT NULL,
  `description_serv` text,
  `amount` float(8,2) DEFAULT NULL,
  PRIMARY KEY (`serviceid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`serviceid`, `title`, `description_serv`, `amount`) VALUES
(1, 'СКАЗОЧНЫЙ ЛЕС МАШИ И МЕДВЕДЯ', 'Наши сказочные друзья придут к вам на праздник, чтобы научить самым зажигательным танцам, шалостям и окунутся в атмосферу любимого мультфильма! Ребятишки смогут стать юными поварятами, раскрыть тайну загадочной полянки и пройти курс начинающего Айболита, похулиганить так, чтобы об этом не узнал Мишка, а также смогут попробовать себя в роли заботливых родителей!А может, Ваш ребенок всегда хотел быть участником рок-группы, но не предоставлялось возможности?! \r\nКак у взрослых, так и у детей не останется ни капли сомнений о подлинности героев! Маленькая непоседа Маша и добродушный Мишка помогут Вам погрузиться в настоящую сказку!', 2400.00),
(2, 'ЛУНТИК И МИЛА', 'Самый добрый и милый герой, прилетевший к нам с Луны, поднимающий настроение одним своим появлением и веселящими проделками, Лунтик, окажется на Вашем празднике с весьма необычной задачей – построить луноход! Вместе со своей оптимистичной подружкой Милой он подготовит ребят к полету на Луну!\r\nВ школу космонавтов сможет попасть каждый, ведь в этом помогут жители леса: Генерал Шер и Баба Капа, Вупсень и Пупсень, Корней Корнеевич и Пескарь Иванович, Кузя и Пчелёнок. Герои любимого мультфильма дадут важные уроки юным покорителям космоса, которые пригодятся и в обычной жизни! Лунтик и Мила создадут прекрасное настроение, ведь у них в запасе самый космический реквизит.', 1500.00),
(3, 'ТРОЛЛИ', 'Dance, dance, dance!\r\nСплошные танцы и удовольствие, — быть троллем легко и просто. Особенно, когда не надо прятаться от бергенов.\r\nЖизнь наладилась, и каждый день — праздник.\r\nЧтобы праздник удался, мы приготовили самый яркий и качественный реквизит.\r\nПазл, воссоздающий удивительный мир троллей. Моталки, позволяющие, прямо как в мультфильме, удлинять и укорачивать волосы. Туннель, ведущий в тайное убежище Цветана. Следы, запутывающие бергенов. Неповторимый набор паричков и гитар для создания собственной тролльской музыкальной группы.\r\nВсё это при помощи волшебства и наших стараний превратит любой праздник в незабываемую вечеринку.\r\nГотовьте ваши ноги для танцев , а руки для аплодисментов.\r\nПраздник начинается!', 2000.00),
(4, 'КРИО ШОУ', 'Минус 196 градусов по Цельсию - это вам не шутки! Вместе с чокнутым профессором дети будут укрощать жидкий азот! Мы будем замораживать органику, неживые вещи, и даже обливаться жидким азотом без вреда для здоровья! В конце будут эксперименты с вакуумом и крутые селфи. ', 800.00),
(5, 'БУМАЖНОЕ ШОУ', 'Бумажное шоу – одно из самых ярких и зрелищных шоу на «десерт» или финалы мероприятия. Килограммы нарезанной бумаги, тысячи лепестков конфетти, тематические костюмы в зависимости от мероприятия, веселые ведущие и, конечно же, тематическая музыка. И все это - бумажное шоу, которое подарит бурю эмоций как детям, так и взрослым. Будет жарко! ', 1000.00),
(6, 'ПИНЬЯТА', 'Самое распространённое развлечение Мексики перекочует на Ваш праздник! Пиньята, известная игрушка из папье-маше, наполненная вкусными сюрпризами, станет отличной добавкой, которая развеселит именинника! Но просто так сладости не достать, перед этим нужно как следует повеселиться! Виновнику торжества вручат специальную палку, завяжут глаза, раскрутят и при этом он должен попасть по подвешенной игрушке, чтобы добыть вкусный подарок! Улыбки и смех гарантированы, ведь это поднимет настроение не только имениннику, но и его друзьям!', 1200.00),
(7, 'КУЛИНАРНЫЙ МАСТЕР-КЛАСС', 'Вкусные, познавательные мастер-классы для детей от 3 лет. Дети учатся работать с кухонными приборами, узнают о пользе продуктов. Каждый поваренок имеет свою униформу и рабочее место, в финале мастер-класса забирает блюдо, приготовленное своими руками, уносит с собой море позитива и рецепт приготовленного блюда!', 800.00),
(8, 'CANDY BOX', 'Candy Box - это тематический набор декоративных элементов для оформления сладкого cтола: от салфеток до трубочек для напитков. Candy Box станет оригинальным дополнением не только к праздничному столу, но и к дизайнерскому оформлению вашей площадки, и сделает торжество красивее.', 500.00);

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE IF NOT EXISTS `workers` (
  `workerid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employid` int(10) unsigned NOT NULL DEFAULT '0',
  `orderid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`workerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`workerid`, `employid`, `orderid`) VALUES
(1, 0, 1),
(2, 0, 1),
(3, 0, 2),
(4, 0, 2),
(5, 0, 3),
(6, 0, 3),
(7, 0, 4),
(8, 1, 4),
(9, 4, 5),
(10, 5, 6),
(11, 3, 6),
(12, 1, 7),
(13, 0, 7),
(14, 0, 7),
(15, 0, 11),
(16, 0, 11),
(17, 0, 11),
(18, 0, 11),
(19, 0, 12),
(20, 0, 12),
(21, 0, 12),
(22, 0, 13),
(23, 0, 13),
(24, 0, 13),
(25, 0, 13),
(26, 0, 14),
(27, 0, 14),
(28, 1, 15),
(29, 0, 15),
(30, 0, 16),
(31, 0, 17),
(32, 0, 17),
(33, 0, 17);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;