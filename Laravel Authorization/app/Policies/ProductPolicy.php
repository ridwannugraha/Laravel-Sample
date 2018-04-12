<?php

namespace App\Policies;

use App\User;
use App\Product;
use App\Staff;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function view(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can create products.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $toko  = $user->toko()->firstOrfail();
        $staff = $this->staff($user,$toko);

        return $staff->roles->permission->create_produk ;
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        $toko  = $user->toko()->firstOrfail();
        $staff = $this->staff($user,$toko);

        return $product->toko_id === $toko->id && $staff->roles->permission->update_produk ;
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        $toko  = $user->toko()->firstOrfail();
        $staff = $this->staff($user,$toko);

        return $product->toko_id === $toko->id && $staff->roles->permission->delete_produk ;
    }

    public function staff($user, $toko){
        return Staff::where('toko_id',$toko->id)
                    ->where('user_id',$user->id)
                    ->with(['roles' => function($query){
                        return $query->with(['permission']);
                    }])->firstOrfail();
    }
}
