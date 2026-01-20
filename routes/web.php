<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyController;

// Redirect home to families
Route::get('/', function () {
    return redirect()->route('families.index');
});

// Custom Family Routes (harus didefinisikan sebelum resource)
Route::get('families/tree/view', [FamilyController::class, 'tree'])->name('families.tree');
Route::get('families/tree-data/{family?}', [FamilyController::class, 'getTreeData'])->name('families.getTreeData');
Route::post('families/relationship/add', [FamilyController::class, 'addRelationship'])->name('families.addRelationship');
Route::delete('families/relationship/remove', [FamilyController::class, 'removeRelationship'])->name('families.removeRelationship');

// Standard CRUD Routes
Route::resource('families', FamilyController::class);
