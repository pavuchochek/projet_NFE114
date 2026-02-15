<?php
require_once("../dao/SalleDAO.php");
class ControllerSalles
{

    public static function getSalleById(mixed $id): ?Salle
    {
        return SalleDAO::getSalleById($id);
    }

    public static function getAllSalles(): array
    {
        $salles = SalleDAO::getAllSalles();
        if($salles) {
            $sallesArray = [];
            foreach ($salles as $salle) {
                $sallesArray[] = $salle->toArray();
            }
            return $sallesArray;
        }
        return [];
    }
}