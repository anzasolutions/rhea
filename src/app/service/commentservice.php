<?php

namespace app\service;

use core\db\exception\NoResultException;
use core\db\exception\QueryException;
use core\service\AbstractService;
use core\service\ServiceException;
use core\system\session\SessionUser;

use app\model\Comment;

class CommentService extends AbstractService
{
    public function addAjax($typeName, $typeId, $content)
    {
        $comment = $this->makeComment($typeName, $typeId, $content);
        $this->dao->comment->save($comment);
    }

    private function makeComment($typeName, $typeId, $content)
    {
        $user = SessionUser::getInstance()->getUser();
        $type = $this->dao->commentType->findByName($typeName);

        $comment = new Comment();
        $comment->setContent($content);
        $comment->setCommentType($type);
        $comment->setTypeId($typeId);
        $comment->setDate(null);
        $comment->setUser($user);
        return $comment;
    }

    // TODO: local variables could be customizable?
    // TODO: variable names could be enhanced?
    public function getComments($type, $typeId, $start)
    {
        $span = 10;
        $limit = 10;
        $position = 0;

        if ($start != null)
        {
            $total = $start * $span;
            $position = $total - $span;
        }
        
        try
        {
            return $this->dao->comment->findByCommentTypeNameAndTypeIdAndLimit($type, $typeId, $position, $limit);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }

    public function getCommentsNumber($type, $typeId)
    {
        try
        {
            return $this->dao->comment->countByCommentTypeNameAndTypeId($type, $typeId);
        }
        catch (QueryException $e)
        {
            throw new ServiceException();
        }
    }
}

?>