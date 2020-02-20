<?php
class vk_bot
{
    private $access_token = NULL;
    private $emptyKeyboard = NULL;
    private $VK_API_VERSION = NULL;
    private $groupID = NULL;

    function __construct($access_token, $group_id)
    {
        $this->access_token = $access_token;
        $this->emptyKeyboard = json_encode(array(
            "one_time" => true,
            "buttons" => []
        ));
        $this->VK_API_VERSION = 5.5;
        $this->groupID = $group_id;
    }

    // Шаблон, как должен заполняться массив кнопок:
    //  {
    //      "caption": "button label text",
    //      "color": "button color – red, creen, blue or white",
    //      "row_num": "Number of the row",
    //  }
    // Все кнопки, при этом, уже должны лежать в правильном порядке
    // Дополнительно можно сделать клавиатуру отображающуюся постоянно, передав вторым параметром false
    function getKeyboard($buttons, $one_time = true)
    {
        $res = Array("one_time" => $one_time, "buttons" => Array());

        $rowCount = 0;
        foreach ($buttons as $button) {
            if ($button['button_row'] > $rowCount)
                $rowCount = $button['button_row'];
        }

        for ($i = 0; $i < $rowCount; $i++) {
            array_push($res['buttons'], Array());

            foreach ($buttons as $button) {
                if ($button['button_row'] != $i + 1)
                    continue;

                $color = 'default';

                switch ($button['color']) {
                    case 'red': {
                        $color = 'negative';
                        break;
                    }
                    case 'green': {
                        $color = 'positive';
                        break;
                    }
                    case 'blue': {
                        $color = 'primary';
                        break;
                    }
                }

                array_push($res['buttons'][$i], Array("action" => Array("type" => "text", "label" => $button['caption']), "color" => $color));
            }
        }

        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    // Отправляем сообщение пользователю
    function sendMessage($userID, $message, $keyboard = NULL)
    {
        if ($keyboard == NULL)
            $keyboard = $this->emptyKeyboard;

        $request_params = array(
            'message' => $message,
            'keyboard' => $keyboard,
            'user_id' => $userID,
            'access_token' => $this->access_token,
            'v' => $this->VK_API_VERSION
        );
        $get_params = http_build_query($request_params);

        return file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
    }

    // Получаем данные пользователя
    function getUserInfo($userID)
    {
        $request_params = array(
            'user_id' => $userID,
            'access_token' => $this->access_token,
            'v' => $this->VK_API_VERSION
        );
        $get_params = http_build_query($request_params);
        $res = file_get_contents('https://api.vk.com/method/users.get?' . $get_params);
        $res = json_decode($res);

        return Array(
            'name' => $res->response[0]->first_name,
            'surname' => $res->response[0]->last_name
        );
    }

    // Проверяем состоит ли пользователь в группе
    // 1 – состоит; 0 – не состоит
    function isGroupMember($userID)
    {
        $request_params = array(
            'group_id' => $this->groupID,
            'user_id' => $userID,
            'access_token' => $this->access_token,
            'v' => $this->VK_API_VERSION
        );
        $get_params = http_build_query($request_params);
        $res = file_get_contents('https://api.vk.com/method/groups.isMember?' . $get_params);
        $res = json_decode($res);

        return $res->response;
    }
}
?>