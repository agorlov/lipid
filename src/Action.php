<?php
namespace Lipid;

//use AG\Response;

interface Action
{
    public function handle(Response $resp): Response;
}
