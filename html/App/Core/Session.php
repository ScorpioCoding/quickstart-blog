<?php

namespace App\Core;

class Session
{

  public function __construct(?string $cacheExpire = null, ?string $cacheLimiter = null)
  {
    if (session_status() === PHP_SESSION_NONE) {

      if ($cacheLimiter !== null) {
        session_cache_limiter($cacheLimiter);
      }

      if ($cacheExpire !== null) {
        session_cache_expire($cacheExpire);
      }

      session_start();
    }
  }



  public function set($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  public function get($key)
  {
    if ($this->has($key)) {
      return $_SESSION[$key];
    }
    return null;
  }

  public function remove(string $key): void
  {
    if ($this->has($key))
      unset($_SESSION[$key]);
  }

  public function clear(): void
  {
    session_unset();
  }

  public function has(string $key): bool
  {
    return array_key_exists($key, $_SESSION);
  }

  public function dump()
  {
    echo '<pre> Session dump <br>';
    var_dump($_SESSION);
    echo '</pre>';
  }

  public function destroy()
  {
    session_destroy();
  }
}
