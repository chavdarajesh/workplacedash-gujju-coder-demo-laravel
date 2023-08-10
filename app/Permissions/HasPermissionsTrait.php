<?php 
namespace App\Permissions;

use App\Permission;
use App\Roles;

trait HasPermissionsTrait {

   public function givePermissionsTo(... $permissions) {

    $permissions = $this->getAllPermissions($permissions);
    dd($permissions);
    if($permissions === null) {
      return $this;
    }
    $this->permissions()->saveMany($permissions);
    return $this;
  }

  public function withdrawPermissionsTo( ... $permissions ) {

    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;

  }

  public function refreshPermissions( ... $permissions ) {

    $this->permissions()->detach();
    return $this->givePermissionsTo($permissions);
  }

  public function hasPermissionTo($permission) {
    /*if($this->hasPermissionThroughRole($permission)){
      return true;
    }*/
    if($this->hasPermission($permission)){
      return true;
    }
    return false;
    //return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
  }

  public function hasPermissionThroughRole($permission) {
    
    foreach ($permission->roles as $role){
      if($this->roles->contains($role)) {
        return true;
      }
    }
    return false;
  }

  public function hasRole( ... $roles ) {

    foreach ($roles as $role) {
      if ($this->roles->contains('r_name', $role)) {
        return true;
      }
    }
    return false;
  }

  public function roles() {

    return $this->belongsToMany(Roles::class,'users_roles');

  }
  public function permissions() {

    return $this->belongsToMany(Permission::class,'users_permissions');

  }
  protected function hasPermission($permission) {
    //dd($permission->pm_id);exit;
    return (bool) $this->permissions->where('pm_name', $permission->pm_name)->count();
  }

  protected function getAllPermissions(array $permissions) {

    return Permission::whereIn('pm_name',$permissions)->get();
    
  }

}
?>