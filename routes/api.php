<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StuDeptController;
use App\Http\Controllers\TeacherDepartmentController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\BroadcastController;
use App\Models\User;
use PHPUnit\Framework\Attributes\PostCondition;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//User
Route::post('/users/login',[UserController::class, 'login']);
Route::get('/user', [UserController::class, 'show'])->middleware('auth:sanctum');

// --- Using Sanctum ---
Route::middleware(['auth:sanctum'])->controller(UserController::class)->prefix('/users')->group(function(){
    Route::get('/', 'index');
    Route::post('/','store');
    Route::get('/me','show'); 
    Route::patch('/','update');
    Route::delete('/','delete');
    Route::post('/logout', 'logout');
    Route::patch('/{user}/update-status/{action}', 'updateStatus');

    //Admin Route
    Route::get('/{user}','show');
    Route::patch('/{user}','update');

});

// --- Using Passport --
// Route::middleware(['auth:api', 'administrator'])->controller(UserController::class)->prefix('/users')->group(function(){
//     Route::get('/', 'index');
//     Route::post('/','store');
//     Route::get('/{user}','show'); 
//     Route::patch('/{user}','update');
//     Route::delete('/','delete');
//     Route::post('/logout', 'logout');

// });
// Route::middleware('auth:api')->controller(UserController::class)->prefix('/users')->group(function () {
//     Route::get('/', 'index');
    // Route::post('/','store');
//     Route::get('/{user}','show'); 
//     Route::patch('/{user}','update');
//     Route::delete('/{user}','delete');
// });
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/users', [UserController::class, 'index']);
// Route::post('/user', [UserController::class, 'store']);
// Route::get('/user/{user}', [UserController::class,'show']);
// Route::patch('/edit-user/{user}', [UserController::class,'update']);
// Route::delete('/remove-user/{user}', [UserController::class,'delete']);

//Car 
Route::get('/car/{car}', [CarController::class, 'show'])->middleware(['auth:api', 'user.car']);

Route::controller(CarController::class)->prefix('cars')->group(function(){
    Route::get('/', 'index');
    Route::post('/{user}', 'store');
    Route::get('/car/{car}', 'show');
    Route::get('/image-url/{car}', 'getImageUrl');
    Route::patch('/{car}', 'update');
});


// Route::get('/teacher', [TeacherController::class,'index']);
// Route::post('/add-teacher', [TeacherController::class,'store']);
// Route::get('/teacher/{teacher}', [TeacherController::class,'show']);
// Route::patch('/edit-teacher/{teacher}', [TeacherController::class,'update']);
// Route::delete('/teacher/{teacher}', [TeacherController::class,'delete']);

//Employee / Contact / Manager
Route::controller(EmployeeController::class)->prefix('/employee')->group(function(){
    Route::get('/','index');
    Route::post('/manager/{manager}', 'store');
    Route::get('/{employee}', 'show');
});

Route::controller(ContactController::class)->group(function(){
    Route::get('/contact', 'index');
    Route::post('/employee/{employee}/contact', 'store');
});

Route::controller(ManagerController::class)->prefix('/manager')->group(function(){
    Route::get('/', 'index');
    Route::post('/', 'store');
});

//Stu / dept / Teacher_dept / Teacher
Route::controller(TeacherController::class)->prefix('/teachers')->group (function () {
    Route::get('/', 'index');
    Route::get('/teacherdepartment', 'teacherdepartment'); //many-to-many
    Route::post('/', 'store');
    Route::get('/{teacher}', 'show');
    Route::patch('/{teacher}', 'update');
    Route::delete('/{teacher}', 'delete');
});
Route::controller(StudentController::class)->prefix('/students')->group(function(){
    Route::post( '/', 'store');
    Route::get('/', 'index');
});

Route::controller(DepartmentController::class)->prefix('/department')->group(function(){
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::patch('/{department}/{action}', 'updateDepartment');
});

Route::controller(TeacherDepartmentController::class)->group(function(){
    Route::post('/{teacher}/teacher_dept', 'store');
    Route::patch('/teacher/{teacher}/department', 'update');
    Route::delete('/teacher/{teacher}', 'delete');
});

// post / video
Route::controller(PostController::class)->prefix('/post')->group(function(){
    Route::get('/', 'index');   
    Route::post('/', 'store');
    Route::get('/{post}', 'show');
    Route::patch('/{post}', 'update');
});
Route::controller(VideoController::class)->prefix('/video')->group(function(){
    Route::post('/', 'store');
});
Route::controller(CommentController::class)->prefix('/comments')->group(function(){
    Route::get('/', 'index');
    Route::post('/{commentable_type}/{commentable_id}', 'store');
    Route::patch('/{commentable_type}/{commentable_id}', 'update');
});

//--- Collection ---
Route::get('/test-collection', [CollectionController::class, 'test']);


//Implicit Binding
// Route::get('/users/{user}', function(User $user)
// {
//     echo $user->email;
//     echo $user->name;
// });



// -- Broadcast --
Route::middleware(['auth:sanctum'])->controller(BroadcastController::class)->prefix('/sent-message')->group(function(){
    Route::post('/', 'sendNotification');
});
?>