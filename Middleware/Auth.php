<?php

namespace Middleware\Auth;

//
// Auth middleware
class AuthMiddleware extends \Slim\Middleware
{
  protected $acl;

  public function __construct($acl)
  {
    $this->acl = $acl;
  }

  public function call()
  {
    $this->app->hook('slim.before.dispatch', array($this, 'onBeforeDispatch'));

    $this->next->call();
  }

  public function onBeforeDispatch()
  {
    $route = $this->app->router()->getCurrentRoute()->getPattern();
    $params = $this->app->request->params();

    $this->checkAcl($route,$params);
  }

  protected function checkAcl($route, $params) {

    // brute function to check each route then get its acl requirements
    foreach ($this->acl as $key => $value) {

      // full string match. consider also other substring match possibility
      if ($key == $route) {
        $this->app->log->debug('Check ACL');

        foreach ($value as $acl) {
          
          // check if valid member
          if ($acl == 'member') {

            if (!isset($params['token'])) {
              endResponse(403, 'Error', 'Invalid credentials. No token are provided.', null, $this->app);
            }

            if ($params['token'] != 'aMxRfN0TjOc9UzUmG3SgtMvv02E7FhoK') {
              endResponse(403, 'Error', 'Invalid token. Perhaps expired.', null, $this->app);
            }
          }

          // check if valid subscriber
          if ($acl == 'subscribe') {
            $this->app->log->debug('Check Subscription');
          }

        } // each acl values

      } 

    } // each route in acl
  }

}