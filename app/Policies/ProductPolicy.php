<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    /**
     * Se for admin, permite tudo.
     */
    public function before(User $user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Usuário só vê produto se for dono.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }

    /**
     * Usuário só atualiza se for dono.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }

    /**
     * Usuário só deleta se for dono.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }
}
