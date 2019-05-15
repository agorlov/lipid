<?php
namespace AG\WebApp;

//use AG\Response;

interface Action
{
    public function handle(Response $resp): Response;
}
