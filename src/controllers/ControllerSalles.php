<?php

class ControllerSalles
{

    public static function getSalleById(mixed $id): ?Salle
    {
        return SalleDAO::getSalleById($id);
    }

    public static function getAllSalles(): array
    {
        return SalleDAO::getAllSalles();
    }
}