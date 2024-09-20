<?php
namespace App\interface;
use Illuminate\Http\Request;

interface UserInterface{
    public function show($user);
    public function update(Request $request, User $user);
}
?>
