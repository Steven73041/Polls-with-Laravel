<?php
if (!function_exists('user_has_voted_this')) {
    function user_has_voted_this($poll_id) {
        $user = auth()->user();
        $new_arr = [];
        $votes = $user->votes;
        if (count($votes)) {
            foreach ($votes as $vote) {
                $new_arr[] = $vote->poll_id;
            }
            if (in_array($poll_id, $new_arr)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('user_voted_category')) {
    function user_voted_category($category_id) {
        $user = auth()->user();
        $ids = [];
        $user_category = $user->categories()->find($category_id);
        if ($user_category) {
            $user_polls = $user_category->polls;
            foreach ($user_polls as $poll) {
                if (!user_has_voted_this($poll->id)) {
                    $ids[] = $poll->id;
                }
            }
            if (!empty($ids)) {
                return false;
            } else {
                return true;
            }
        }
    }
}

if (!function_exists('user_voted_categories')) {
    function user_voted_categories() {
        $user = auth()->user();
        $ids = [];
        $user_categories = $user->categories;
        foreach ($user_categories as $category) {
            if (!user_voted_category($category->id)) {
                $ids[] = $category->id;
            }
        }
        if (!empty($ids)) {
            return false;
        } else {
            return true;
        }
    }
}
