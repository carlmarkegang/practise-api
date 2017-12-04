<?php

class PostModel
{

    function getPosts($type, $parent = null, $limit = 100, $id = null, $offset = false)
    {
        $db = new db();
        $query = "SELECT posts.*,SUBSTRING(from_unixtime(created), 1, 19) as converted_time FROM posts where deleted != 1 ";
        if ($type == "main") {
            $query .= "and type='main' limit $limit";
        } else if ($type == "sub") {
            $query .= "and type='sub' and parent='$parent' order by id asc limit $limit";
        } else if ($type == "id") {
            $query .= "and type='main' and id = $id";
        }

        if($offset)
            $query .= " offset $offset";

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
        $query = "SELECT id,text,user_id,created FROM posts where deleted != 1 and type='main' AND user_id='$user' order by created desc limit $limit ";
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
        $query = "SELECT id,text,user_id,created,parent FROM posts where deleted != 1 and type='sub' AND user_id='$user' order by created desc limit $limit";
        if ($result = $db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $results_array[] = $row;
            }
            return $results_array;
        }
    }

    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
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