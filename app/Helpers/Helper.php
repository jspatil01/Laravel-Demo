<?php
namespace App\Helpers;  
use App\Models\Manager;
use App\Models\Employee;

class Helper{
    public static function upperName($string){
        return strtoupper($string);
    }

    public static function getEmployeeDetails(Employee $employee){
        return $employee->contact;        
    }
}
?>
