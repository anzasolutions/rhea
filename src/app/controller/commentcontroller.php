<?php

namespace app\controller;

use core\controller\Controller;
use core\service\ServiceException;

/**
 * @Session
 */
class CommentController extends Controller
{
    private $type;

    /**
     * @PostConstruct
     */
    public function init()
    {
        parent::init();
        $this->type = $this->url->getController();
    }

    /**
     * @Invocable
     */
    protected function index()
    {
        $this->redirectToError();
    }

    public function getComments()
    {
        try
        {
            $this->commentsNo = $this->service->comment->getCommentsNumber($this->type, $this->url->getParameter(0));
            if ($this->commentsNo > 0)
            {
                $this->comments = $this->service->comment->getComments($this->type, $this->url->getParameter(0), $this->url->getParameter(1));
                $this->commentPageNumbers = ceil($this->commentsNo / 10);
            }
        }
        catch (ServiceException $e)
        {
            $this->redirectToError();
        }
    }

    /**
     * @Invocable
     * @WebMethod
     * @Form = "comment"
     */
    public function addAjax($form)
    {
        $typeName = $form->getType();
        $typeId = $form->getId();
        $content = $form->getComment();
        $this->type = $typeName;
        $this->url->setParameters($typeId);
        $this->service->comment->addAjax($typeName, $typeId, $content);
        $this->getComments();
    }
}

?>