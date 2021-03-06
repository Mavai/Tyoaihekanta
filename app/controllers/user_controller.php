<?php

class UserController extends BaseController {

    public static function login($previous) {
        View::make('login.html', array('previous' => $previous));
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['username'], $params['password']);
        $previousURL = $params['previous'];
        if ($previousURL == null) {
            $previousURL = 'tsohaprojekti/';
        }
        $previous = explode('tsohaprojekti', $previousURL);

        if (!$user) {
            View::make('login.html', array('error' => 'Väärä käyttäjätunnus tai salasana', 'username' => $params['username']));
        }
        $_SESSION['user'] = $user->id;
        
        if ($previous != " ") {
            Redirect::to($previous[1], array('message' => 'Tervetuloa, ' . $user->name));
        } else {
            Redirect::to('/', array('message' => 'Tervetuloa' . $user->name));
        }
    }

    public static function logout($previous) {
        self::check_logged_in();
        $_SESSION['user'] = null;
        $prev = explode('tsohaprojekti', $previous);
        Redirect::to($prev[1], array('message' => 'Olet kirjautunut ulos'));
    }

}
