<section id="company_info">
    <form>
        <div class="form-row readonly">
            <span class="c1">Название компании:</span>
            <input class="c2 readonly" readonly type="text" name="name" placeholder="Название компании" value="<?=$data['company_info']['name'];?>">
            <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
        </div>

        <div class="form-row w1-2 readonly">
            <span class="c1">Несколько слов о компании:</span>
            <textarea class="c2 readonly" readonly name="description" placeholder="О компании"><?=$data['company_info']['description'];?></textarea>
            <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
        </div>

        <div class="form-row w1-2 readonly">
            <span class="c1">Адресс главного офиса:</span>
            <textarea class="c2 readonly" readonly name="address" placeholder="Адресс главного офиса"><?=$data['company_info']['address'];?></textarea>
            <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
        </div>

        <div class="form-row w1-3 readonly">
            <span class="c1">Адрес сайта:</span>
            <input class="c2 readonly" readonly type="text" name="webPage" placeholder="https://">
            <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
        </div>

        <div class="form-row w1-3 readonly">
            <span class="c1">Профиль вконтакте:</span>
            <input class="c2 readonly" readonly type="text" name="vkLink" placeholder="Профиль вконтакте">
            <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
        </div>

        <div class="form-row w1-3 readonly">
            <span class="c1">Профиль Instagram:</span>
            <input class="c2 readonly" readonly type="text" name="instagramLink" placeholder="Профиль Instagram">
            <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
        </div>

        <div class="form-row w1-2 readonly">
            <span class="c1">Контактный телефон:</span>
            <input class="c2 readonly" readonly type="text" name="phone" placeholder="Контактный телефон" value="<?=$data['company_info']['phone'];?>">
            <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
        </div>

        <div class="form-row w1-2 readonly">
            <span class="c1">Контактный email:</span>
            <input class="c2 readonly" readonly type="email" name="email" placeholder="Контактный email" value="<?=$data['company_info']['email'];?>">
            <span class="chars-left"><span class="chars-left-value">0</span>/255</span>
        </div>

        <div class="ctrl-buttons">
            <button id="edit_company_info">Изменить</button>
            <button id="update_company_info" class="ui-helper-hidden">Сохранить</button>
            <button id="cancel" class="ui-helper-hidden">Отменить</button>
        </div>
    </form>
</section>