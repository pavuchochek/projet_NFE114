<?php
require_once '../dao/CoachDAO.php';
class ControllerCoachs
{
    public static function getCoachById(mixed $id, $role, $userId)
    {
        if($role=="coach" && $userId == $id) {
            return CoachDAO::getCoachById($id);
        }

        return false;
    }

    public static function getAllCoachs($role)
    {
        if($role=="admin") {
            return CoachDAO::getAllCoachs();
        }

        return false;
    }
}