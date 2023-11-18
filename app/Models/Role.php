<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;


    protected $fillable=['name'];



    public  static function createRoleAndAbility(Request $request){
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name'=>$request->post('name')
            ]);

            foreach ($request->post('abilities')as $ability){
                RoleAbilities::create([
                    'role_id'=> $role->id,
                    'ability_id' => $ability,
                    'type' => 'allow'
                ]);

            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }


        return $role;
    }
    public   function updateRoleAndAbility(Request $request){
        DB::beginTransaction();
        try {
            $this->update([
                'name'=>$request->post('name')
            ]);

            foreach ($request->post('abilities')as $ability){
                RoleAbilities::updateOrCreate([
                    'role_id'=> $this->id,
                    'ability_id' => $ability,

                ] ,[
                    'type' => 'allow'
                ]);

            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }


        return $this;
    }
}