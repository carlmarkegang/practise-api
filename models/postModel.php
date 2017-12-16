<?php

class PostModel
{

    function getPosts($type, $parent = null, $limit = 100, $id = null, $offset = false)
    {
        $db = new db();
        $query = "SELECT * FROM posts WHERE deleted != 1 ";
        if ($type == "main") {
            $query .= "AND type='main'";
        } else if ($type == "sub") {
            $query .= "AND type='sub' AND parent='$parent'";
        } else if ($type == "id") {
            $query .= "AND type='main' AND id = $id";
        }

        $query .= " ORDER BY created ASC limit " . $limit;

        if ($offset)
            $query .= " OFFSET $offset";

        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $results_array[] = $row;
            }
            return $results_array;
        }
    }

    function getSubPostAmount($id = null)
    {
        $db = new db();
        $query = "SELECT id FROM posts where type='sub' and parent='$id' and deleted != 1";
        if ($result = $db->query($query)) {
            $rowCount = $result->num_rows;
            return $rowCount;
        }
    }

    function getUserSpecificMainPosts($user = null, $limit = 100)
    {
        $db = new db();
        $query = "SELECT * FROM posts where deleted != 1 and type='main' AND user_id='$user' order by created desc limit $limit ";
        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $results_array[] = $row;
            }
            return $results_array;
        }
    }


    function getUserSpecificSubPosts($user = null, $limit = 100)
    {
        $db = new db();
        $query = "SELECT * FROM posts where deleted != 1 and type='sub' AND user_id='$user' order by created desc limit $limit";
        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $results_array[] = $row;
            }
            return $results_array;
        }
    }

    function getParentIdFromSub($id = null)
    {
        $db = new db();
        $query = "SELECT parent FROM posts where id='$id'";
        if ($result = $db->query($query)) {
            $data = $result->fetch_row();
            return $data[0];
        }
    }

    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime();
        $ago->setTimestamp($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}