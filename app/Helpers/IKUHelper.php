<?php

namespace App\Helpers;

use App\Models\IKU7;

class IKUHelper
{
    public static function scoresAreFilled(IKU7 $iku): bool
    {
        return !is_null($iku->score_case_method) &&
               !is_null($iku->score_project_based) &&
               !is_null($iku->score_cognitive_task) &&
               !is_null($iku->score_cognitive_quiz) &&
               !is_null($iku->score_cognitive_uts) &&
               !is_null($iku->score_cognitive_uas);
    }

    public static function descriptionAreFilled(IKU7 $iku): bool
    {
        return !is_null($iku->description_case_method) &&
               !is_null($iku->description_project_based) &&
               !is_null($iku->description_cognitive_task) &&
               !is_null($iku->description_cognitive_quiz) &&
               !is_null($iku->description_cognitive_uts) &&
               !is_null($iku->description_cognitive_uas) &&
               !is_null($iku->file_rps);
    }
}
