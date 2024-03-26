<?php
namespace App\Repositories;

use App\Models\Comment;

class CommentRepository extends BaseRepository
{
    protected $comment;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->setModel();
    }

    public function getModel()
    {
        return Comment::class;
    }
}
