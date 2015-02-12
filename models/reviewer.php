<?php

include_once MODELS_DIR . 'user.php';
include_once MODELS_DIR . 'mailer.php';

class Reviewer
{
    public static function assign($form)
    {
        $survey_id = $form['survey_id'];
        $surplus_fields = ['survey_id', 'survey_name', 'org_id', 'team_id'];
        $assignment = array_diff_key($form,array_flip($surplus_fields));
        $mapping = [];
        $all_reviewers = [];
        foreach($assignment as $reviewee=>$reviewers){
            foreach($reviewers as $reviewer) {
                $mapping[] = ['survey_id' => $survey_id, 'reviewee' => $reviewee, 'reviewer' => $reviewer];
            }
            $all_reviewers = array_merge($all_reviewers, $reviewers);
        }
        DB::insert('reviewers', $mapping);
        $count = self::notify($all_reviewers);
        return ['status'=>'Success', 'value'=>"A notification email has been sent to $count reviewers."];
    }

    private static function notify($all_reviewers)
    {
        $unique_reviewers = array_unique($all_reviewers);
        $user_info = User::bulk_user_info($unique_reviewers);
        foreach($user_info as $user_details) {
            send_mail($user_details, 'new_review');
        }
        return count($unique_reviewers);
    }
}