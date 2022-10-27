<?php

namespace App\Controller;

use App\Infra\Http\Request;
use App\Infra\Http\Response;

/**
 * Indexコントローラ
 */
class IndexController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        if ($this->authService->isAuthorized()) {
            return $this->redirect("/task/create");
        } else {
            return $this->redirect("/login");
        }
    }
}
