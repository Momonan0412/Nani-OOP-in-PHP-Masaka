<?php
class LogoutUser {
    public static function logout() {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        session_destroy();
    }
}
?>
