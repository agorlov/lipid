<?php

namespace Lipid\Session;

use Lipid\Session;

/**
 * @todo #80 rename to SessionStd
 */
final class AppSession implements Session
{
    public function exists($param): bool
    {
        $this->sessionStart();
        return array_key_exists($param, $_SESSION);
    }

    public function get($param)
    {
        $this->sessionStart();
        return $_SESSION[$param] ?? null;
    }

    public function set($param, $value): void
    {
        $this->sessionStart();
        $_SESSION[$param] = $value;
        session_commit();
    }

    public function unset($param): void
    {
        $this->sessionStart();
        unset($_SESSION[$param]);
        session_commit();
    }

    private function sessionStart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}
