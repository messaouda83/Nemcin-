<?php
class AdminDirectorController extends DirectorController
{
    private $adminDirector;

    public function __construct()
    {
        parent::__construct();
        $this->adminDirector = new AdminDirector();
    }
}