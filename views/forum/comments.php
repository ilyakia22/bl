<? foreach ($comments as $row) : ?>
<? if ($row->root_forum_comment_id == 0) : ?>
	<? $comment = $row;
        $isRoot = true;
        $parent = null; ?>
	<? include "comment_view.php" ?>
	<? foreach ($comments as $row2) : ?>
		<? if ($row2->root_forum_comment_id == $row->id) : ?>
			<?
                $comment = $row2;
                $isRoot = false;
                $parent = null;
                if ($comment->parent_forum_comment_id > 0 && isset($comments[$comment->parent_forum_comment_id])) {
                    $parent = $comments[$comment->parent_forum_comment_id];
                }
            ?>
			<? include "comment_view.php" ?>
		<? endif; ?>
	<? endforeach; ?>
<? endif; ?>
<? endforeach; ?>
