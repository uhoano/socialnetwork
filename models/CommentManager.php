<?php
include_once "PDO.php";

function GetOneCommentFromId($id)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM comment WHERE id = :id ");
  $response->execute(
    array(
      "id" => $id
    )
  );
  return $response->fetch();
}

function GetAllComments()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM comment ORDER BY created_at ASC");
  return $response->fetchAll();
}

function GetAllCommentsFromUserId($userId)
{
  global $PDO;
  $response = $PDO->query(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.user_id = $userId "
      . "ORDER BY comment.created_at ASC"
  );
  return $response->fetchAll();
}

function GetAllCommentsFromPostId($postId)
{
  global $PDO;
  $response = $PDO->query(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.post_id = $postId "
      . "ORDER BY comment.created_at ASC"
  );
  $rows = $response->fetchAll();
  return $rows;
}

function CreateNewComment($userId, $postId, $comment)
{
  global $PDO;
  if (!empty($comment)) {
    $preparedRequest = $PDO->prepare("INSERT INTO comment(user_id, post_id, content) values (:userId, :postId, :comment)");
    $preparedRequest->execute(
      array(
        "userId" => $userId,
        "postId" => $postId,
        "comment" => $comment
      )
    );
  }
}
