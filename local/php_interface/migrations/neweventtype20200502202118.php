<?php

namespace Sprint\Migration;


class neweventtype20200502202118 extends Version
{
    protected $description = "added SALE_NEW_ORDER_SELF_DELIVERY";

    protected $moduleVersion = "3.15.1";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Event()->saveEventType('SALE_NEW_ORDER_SELF_DELIVERY', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Новый заказ самовывоз',
  'DESCRIPTION' => '#ORDER_ID# - код заказа
#ORDER_ACCOUNT_NUMBER_ENCODE# - код заказа(для ссылок)
#ORDER_REAL_ID# - реальный ID заказа
#ORDER_DATE# - дата заказа
#ORDER_USER# - заказчик
#PRICE# - сумма заказа
#EMAIL# - E-Mail заказчика
#BCC# - E-Mail скрытой копии
#ORDER_LIST# - состав заказа
#ORDER_PUBLIC_URL# - ссылка для просмотра заказа без авторизации (требуется настройка в модуле интернет-магазина)
#SALE_EMAIL# - E-Mail отдела продаж
#ADDRESS# - Адрес магазина
#SCHEDULE# - Время работы магазина',
  'SORT' => '150',
));
        $helper->Event()->saveEventType('SALE_NEW_ORDER_SELF_DELIVERY', array (
  'LID' => 'en',
  'EVENT_TYPE' => 'email',
  'NAME' => '',
  'DESCRIPTION' => '',
  'SORT' => '150',
));
        $helper->Event()->saveEventMessage('SALE_NEW_ORDER_SELF_DELIVERY', array (
  'LID' =>
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#SALE_EMAIL#',
  'EMAIL_TO' => '#EMAIL#',
  'SUBJECT' => '#SITE_NAME#: Новый заказ самовывоз N#ORDER_ID#',
  'MESSAGE' => '<style>
		body
		{
			font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
<tbody>
<tr>
	<td height="83" width="850" bgcolor="#eaf3f5" style="border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td bgcolor="#ffffff" height="75" style="font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;">
				 Вами оформлен заказ в магазине #SITE_NAME#
			</td>
		</tr>
		<tr>
			<td bgcolor="#bad3df" height="11">
			</td>
		</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;">
		<p style="margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;">
			 Уважаемый #ORDER_USER#,
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			 Ваш заказ номер #ORDER_ID# от #ORDER_DATE# принят.<br>
 <br>
			 Стоимость заказа: #PRICE#.<br>
 <br>
			 Состав заказа:<br>
			 #ORDER_LIST#
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			Адрес получение товара для самовывоза:&nbsp;#ADDRESS#.
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
			Время работы магазина:&nbsp;#SCHEDULE#.
		</p>
		<p style="margin-top: 0; margin-bottom: 20px; line-height: 20px;">
 <br>
			 Вы можете следить за выполнением своего заказа (на какой стадии выполнения он находится), войдя в Ваш персональный раздел сайта #SITE_NAME#.<br>
 <br>
			 Обратите внимание, что для входа в этот раздел Вам необходимо будет ввести логин и пароль пользователя сайта #SITE_NAME#.<br>
 <br>
			 Для того, чтобы аннулировать заказ, воспользуйтесь функцией отмены заказа, которая доступна в Вашем персональном разделе сайта #SITE_NAME#.<br>
 <br>
			 Пожалуйста, при обращении к администрации сайта #SITE_NAME# ОБЯЗАТЕЛЬНО указывайте номер Вашего заказа - #ORDER_ID#.<br>
 <br>
			 Спасибо за покупку!<br>
		</p>
	</td>
</tr>
<tr>
	<td height="40px" width="850" bgcolor="#f7f7f7" valign="top" style="border: none; padding-top: 0; padding-right: 44px; padding-bottom: 30px; padding-left: 44px;">
		<p style="border-top: 1px solid #d1d1d1; margin-bottom: 5px; margin-top: 0; padding-top: 20px; line-height:21px;">
			 С уважением,<br>
			 администрация <a href="http://#SERVER_NAME#" style="color:#2e6eb6;">Интернет-магазина</a><br>
			 E-mail: <a href="mailto:#SALE_EMAIL#" style="color:#2e6eb6;">#SALE_EMAIL#</a>
		</p>
	</td>
</tr>
</tbody>
</table>',
  'BODY_TYPE' => 'html',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' =>
  array (
  ),
  'LANGUAGE_ID' => 'ru',
  'EVENT_TYPE' => '[ SALE_NEW_ORDER_SELF_DELIVERY ] Новый заказ самовывоз',
));
    }

    public function down()
    {
        //your code ...
    }
}
