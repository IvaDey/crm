<?php
include_once 'google client/vendor/autoload.php';
include_once 'application/core/dbModel.php';

class google_calendar {
    protected $db = null;
    protected $client = null;
    protected $service = null;
    protected $calendarsList = null;
    protected $owner = null;

    public function __construct()
    {
        $this->db = new mysqli('localhost',
            'cryptomoni_rbs2',
            'muxcIb-cewrys-pynko7',
            'cryptomoni_rbs2',
            '3306');

        $this->client = $this->getClient();
        if (is_object($this->client)) {
            $this->initData();
        }
    }

    public function get_owner()
    {
        return $this->owner;
    }
    public function getCalendarsList()
    {
        return $this->calendarsList;
    }

    public function is_authorized()
    {
        if (is_object($this->client))
            return $this->owner;
        else return 0;
    }
    public function getAuthLink()
    {
        return $this->client;
    }

    public function setAccessCode($authCode)
    {
        if (is_object($this->client)) {
            return Array(
                'error_code' => 1,
                'error_description' => 'Token is already set'
            );
        } else {
            // Временное решение
            // Далее надо будет переписать нормально
            $this->client = $this->getClient($authCode);
            $this->initData();

            return Array(
                'error_code' => 0,
                'error_description' => 'ok',
                'gcalendar_owner' => $this->owner
            );
        }
    }

    // Создание нового календаря
    public function createNewCalendar($master_name)
    {
        // Если есть интеграция с гугл календарем, то создаем новый календарь и возвращаем его id
        // Иначе возвращаем ноль
        if (is_object($this->client)) {
            $calendar = new Google_Service_Calendar_Calendar(Array(
                'summary' => $master_name
            ));
            $gcalId = $this->service->calendars->insert($calendar)->id;
            return Array(
                'id' => $gcalId,
                'link' => 'https://calendar.google.com/calendar/embed?src=' . $gcalId
            );
        } else {
            return 0;
        }
    }
    // Добавление в календарь нового события
    public function createEvent($calendarId, $event)
    {
        if ($calendarId && $event) {
            $event = $this->service->events->insert($calendarId, $event);
            return $event->htmlLink;
        } else {
            return 0;
        }
    }
    // Удаление календаря
    public function deleteCalendar($calendar_id)
    {
        return $this->service->calendarList->delete($calendar_id);
    }

    // Private methods
    private function getClient($authCode = null)
    {
        $client = new Google_Client();
        $client->setApplicationName('IvaDey journal');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
//        $client->setRedirectUri(''); // Сперва надо авторизовать домен и приложение, потом благодаря этому можно будет получать обратный редирект от гугла, а не просить пользователя скопировать и вставить access_token (по идее)
        $client->setAuthConfig('application/core/credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'application/core/token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {

                // Request authorization from the user.
                if ($authCode) {
                    $authCode = trim($authCode);

                    // Exchange authorization code for an access token.
                    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                    $client->setAccessToken($accessToken);

                    // Check to see if there was an error.
                    if (array_key_exists('error', $accessToken)) {
                        throw new Exception(join(', ', $accessToken));
                    }

                    // Save the token to a file.
                    if (!file_exists(dirname($tokenPath))) {
                        mkdir(dirname($tokenPath), 0700, true);
                    }
                    file_put_contents($tokenPath, json_encode($client->getAccessToken()));
                } else {
                    $authUrl = $client->createAuthUrl();
                    return $authUrl;
                }
            }
        }
        return $client;
    }
    private function getCalendars($service)
    {
        $calendarList = $service->calendarList->listCalendarList();
        $result = Array(
            'owner' => '',
            'calendarList' => Array()
        );
        foreach ($calendarList as $calendar) {
            array_push($result['calendarList'], Array(
                'calendarId' => $calendar->id,
                'summary' => $calendar->summary,
                'timeZone' => $calendar->timeZone
            ));
            if ($calendar->primary)
                $result['owner'] = $calendar->id;
        }

        return $result;
    }
    // Инициализация календаря
    private function initData()
    {
        $this->service = new Google_Service_Calendar($this->client);

        $tmp = $this->getCalendars($this->service);
        $this->owner = $tmp['owner'];
        $this->calendarsList = $tmp['calendarsList'];
    }
    // Создание нового календаря
//    function createNewCalendar($service, $calendar)
//    {
//        return $service->calendars->insert($calendar)->id;
//    }
}
