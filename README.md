﻿<h1>REST API</h1>
<p>
	Шаблон строки запроса к API: <code>/api/{collection_name}/[{item_id|collection_method}/[{item_method|method_parametr}/][{method_parametr}/]]</code>.<br>
	<br><br>
	<h5>Общие GET-параметры для всех запросов (необязательные):</h5>
	<dl>
		<dt><q>access_token</q></dt>
			<dd>
				Ключ доступа, необходимый при запросах, требующих определенных прав доступа к данным или их изменению.<br>
				Уникальный ключ доступа для зарегистрированного пользователя генерируется в ответ на запросы <a href="#post-usersauth">авторизации</a> и <a href="#post-users">регистрации пользователей</a>.
			</dd>
		<dt><q>fields</q></dt>
			<dd>Перечень запрашиваемых атрибутов модели, переданных через запятую. По умолчанию отдается весь набор данных.</dd>
		<dt><q>count</q></dt>
			<dd>количество сущностей в ответе</dd>
		<dt><q>offset</q></dt>
			<dd>смещение результатов выборки</dd>
		<dt><q>sort</q></dt>
			<dd>Сортировка результатов запроса. В параметре передается название столбца, по которому выполняется сортировка, ее порядок определяется знаком '-' в случае сортировки по убыванию (DESC) и отсутствием знака '-' для сортировки по возрастанию значений столбца (ASC).</dd>
	</dl>
	<h3>Целевые запросы(конечные точки) API</h3>
	<p>
		<h4><code>GET: /blog/</code></h4>
		<p>Массив статей.</p>
		<h4><code>POST: /blog/</code></h4>
		<p>Создание новой статьи.</p>
		<h4><code>GET: /blog/{article_id}</code></h4>
		<p>Подробные данные.</p>
		<h4><code>PUT: /blog/{article_id}</code></h4>
		<p>Редактирование.</p>
	</p>
	<h3>Ветка доступа к данным пользователей</h3>
	<p>
		<h4><code>GET: /users/</code></h4>
		<p>Перечень всех зарегистрированных пользователей сайта. Запрос окончится неудачей, если в параметрах не был передан ключ доступа авторизованного пользователя. В зависимости от переданного ключа доступа возможны два варианта результата запроса: 
			<ul>
				<li>если <q>access_token</q> соответствует простому пользователю сайта, то запрос вернет лишь основные данные пользователей (user_id, userpic, firstname и lastname);</li>
				<li>если <q>access_token</q> идентифицирует администратора сайта, то возвращается полный набор данных о пользователях.</li>
			</ul>
		</p>
		<h4><code>POST: /users/</code></h4>
		<p>Регистрация нового пользователя на сайте. В случае успешной регистрации пользователя в ответе будет указан ключ доступа (<q>access_token</q>) для нового пользователя.</p>
		<h4><code>GET: /users/{user_id|self}/</code></h4>
		<p>
			Получение данных о пользователе, идентифициремого по идентификатору, переданному в части запроса <q>{user_id}</q>. В случае отсутствия ключа доступа (<q>access_token</q>) в GET-параметрах запроса возвращаются лишь основные данные: user_id, userpic, firstname и lastname.<br>
			Полные данные о пользователе, например <q>email</q>, запрос вернет только в том случае, если в GET-параметрах запроса был передан ключ доступа администратора сайта.<br>
			Ключевое слово <q>{self}</q>, указанное в запросе вместо <q>{user_id}</q>, используется для получения полных данных пользователя, идентифицируемого по ключу доступа из GET-параметров запроса.
		</p>
		<h4><code>PUT: /users/{user_id}/</code></h4>
		<p>Изменение данных пользователя.</p>
		<h4><code>POST: /users/auth/</code></h4>
		<p>Авторизация пользователя.</p>
		<h4><code>POST: /users/generate-new-password/</code></h4>
		<p>
			Создание нового пароля для зарегистрированного пользователя взамен текущего.<br>
			Сгенерированный пароль отправляется на почту пользователя вместе со ссылкой для активации пароля.<br>
			Ссылка для активации пароля имеет следующий вид: http://sitename/api/users/{user_id}/activate-new-password/XXXX/.
		</p>
	</p>
	<h3>Служебная ветка запросов.</h3>
	<p>
		<h4><code>POST: /upload/</code></h4>
		<p>Загрузка файлов на сервер.</p>
	</p>
	<br><br>
	<h2>Backbone.php</h2>
	Программная среда API реализована по образу и подобию Backbone.js.<br>
	Сущности сайта описываются с помощью классов:
	<ul>
		<li><q>Model</q> для описание свойств отдельной сущности;</li>
		<li><q>Collection</q> для описания набора сущностей.</li>
	</ul>
	<p>
		Пример описания классов модели и коллекции для реализации отдельной сущности сайта:<br>
		<pre>
			class Item extends Model {
				protected $_table = "`db_name`.`table_name`";
				
				/** Gun API Methods
				 * param $options - хеш параметров из программной среды, обычно это массив $_GET
				 * _______________   __________________
				 * request_method | | model_method
				public function get_method($options=array()) {
					...
					return $result;
				}
				public function put_method($options=array()) {
					...
					return $result;
				}
				public function delete_method($method_parametr, $options=array()) {
					...
					return $result;
				}
			}
			
			class Items extends Collection {
				public $ModelClass = Item;
				
				/** Gun API Methods
				 * param $options - хеш параметров из программной среды,
				 *                  обычно это массив $_GET, $_POST или $_PUT
				 *  _______________   __________________
				 *  request_method | | collection_method
				public function  get_method($method_parametr, $options=array()) {
					...
					return $result;
				}
				public function post_method($method_parametr, $options=array()) {
					...
					return $result;
				}
				public function put_method($method_parametr, $options=array()) {
					...
					return $result;
				}
			}
		</pre>
	</p>
	<h3>Model</h3>
	<p>
		Экземпляр класса <q>Model</q> имеет следующие методы и свойства:
		
	</p>
	<h3>Collection</h3>
	<p>
		Коллекция определяет свойства и методы, описывающие работу с набором моделей.
		
	</p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
</p>