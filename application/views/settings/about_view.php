<section id="company_info">
    <h2>Информация о компании</h2>

    <form>
        <label class="c1">Название компании<br><input type="text" name="name" placeholder="Название компании" value="<?=$data['company_info']['name'];?>"></label>
        <label class="c1">О компании<br><textarea name="description" placeholder="О компании"><?=$data['company_info']['description'];?></textarea></label>
        <label class="c1">Адресс главного офиса<br><textarea name="address" placeholder="Адресс главного офиса"><?=$data['company_info']['address'];?></textarea></label>
        <label class="c2">Контактный телефон<br><input type="text" name="phone" placeholder="Контактный телефон" value="<?=$data['company_info']['phone'];?>"></label>
        <label class="c2">Контактный email<br><input type="email" name="email" placeholder="Контактный email" value="<?=$data['company_info']['email'];?>"></label>

        <hr>
        <button id="update_company_info" class="ui-helper-hidden">Сохранить изменения</button>
<!--        <button id="cancel_company_info" class="ui-helper-hidden">Отменить изменения</button>-->
    </form>
</section>