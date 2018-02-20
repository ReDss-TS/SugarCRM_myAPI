<?php

class ControllerCrm extends CoreController
{
    protected $models = ['ModelSessions', 'ModelCrm'];
    protected $components = ['Auth'];
    protected $actionsRequireLogin = ['Index'];

    public function actionIndex($param)
    {
        $selectedData['data'] = $this->ModelCrm->getData($param, $this->config['url']);
        $selectedData['module'] = $this->ModelCrm->getSelectModule($param);
        return $selectedData;
    }

    public function actionLogin()
    {
        if ($_POST) {
            $this->authentication();
        }
        if ($this->ModelSessions->issetLogin() == true) {
            $this->locationMainPage();
        }
        return null;
    }

    public function actionLogout()
    {
        session_destroy();
        header("Location: /crm/login");
    }

    public function locationMainPage()
    {
        $uri = include('Config/defController.php');
        header("Location: /" . $uri['controller'] . '/' . $uri['action']);
    }

    private function authentication()
    {
        $login_parameters = array(
            "user_auth" => array(
                "user_name" => $_POST['user_login'],
                "password" => md5($_POST['user_pass']),
                "version" => "1"
            ),
            "application_name" => "RestTest",
            "name_value_list" => array(),
        );

        $login_result = $this->ModelCrm->call("login", $login_parameters, $this->config['url']);

        if (isset($login_result->id) === true) {
            $this->ModelSessions->authenticationToSession($login_result->id, $login_result->name_value_list->user_name->value);
        } else {
            $this->ModelSessions->recordMessageInSession('auth', $login_result->name);
        }
    }
}
