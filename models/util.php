<?php

class Util
{
    public static function add_hyphens($word) {
        $word = trim(preg_replace('/[^a-zA-Z0-9\s_&\\-]+/', '', $word));
        return strtolower(preg_replace('/[\s\W]+/','-',$word));
    }

    public static function validate_form_contains_required_fields($form, $required_fields)
    {
        $errors = '';
        foreach ($required_fields as $required_field => $field_name) {
            if(!array_key_exists($required_field, $form)){
                $errors .= $field_name . " cannot be blank.<br>";
                continue;
            }
            $actual_value = $form[$required_field];
            if(is_string($actual_value)) $actual_value = trim($actual_value);
            if (empty($actual_value)) {
                $errors .= $field_name . " cannot be blank.<br>";
            }
        }
        return $errors;
    }

    public static function tokenize_email_ids($team_members)
    {
        $results = [];
        $team_members = str_replace(">, ", ">,", trim($team_members));
        $all_members = explode(">,", $team_members);
        foreach($all_members as $member) {
            $name_email = explode("<", str_replace(" <", "<", trim($member)));
            $email = str_replace(">", "", trim($name_email[1]));
            $name_without_double_quotes = trim($name_email[0], '"');
            $name = addslashes($name_without_double_quotes);
            $results[$email]= $name;
        }
        return $results;
    }

    public static function convert_to_associative_map($my_array, $key, $value)
    {
        $result = [];
        foreach ($my_array as $each_array) {
            $result[$each_array[$key]] = $each_array[$value];
        }
        return $result;
    }

    public static function convert_to_associative_array($my_array, $key)
    {
        $result = [];
        foreach ($my_array as $each_array) {
            $result[$each_array[$key]] = $each_array;
        }
        return $result;
    }

}