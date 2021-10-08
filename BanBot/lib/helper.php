<?php
function isInGroup($usergroups,$group) {
    $diff = count(array_diff($usergroups, $group));
    
    if ($diff < count($usergroups)) {
        return true;
    }
    else {
        return false;
    }
}
?>
