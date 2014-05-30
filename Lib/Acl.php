<?php

//
// Here, we define route and its auth requirements
function getAcl() {

  $acls = array(
      "/secret"    => array("member"),
      "/moresecret" => array("member","subscribe")
  );

  return $acls;
};